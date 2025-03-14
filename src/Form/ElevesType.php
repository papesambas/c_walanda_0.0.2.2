<?php

namespace App\Form;

use App\Entity\Noms;
use App\Entity\Users;
use App\Entity\Eleves;
use App\Entity\Cercles;
use App\Entity\Classes;
use App\Entity\Niveaux;
use App\Entity\Parents;
use App\Entity\Prenoms;
use App\Entity\Regions;
use App\Entity\Statuts;
use App\Entity\Communes;
use App\Entity\Scolarites1;
use App\Entity\Scolarites2;
use Psr\Log\LoggerInterface;
use App\Entity\Etablissements;
use App\Entity\LieuNaissances;
use Doctrine\ORM\EntityRepository;
use App\Repository\MeresRepository;
use App\Repository\PeresRepository;
use App\Repository\NiveauxRepository;
use App\Repository\StatutsRepository;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use App\Repository\Scolarites2Repository;
use App\Service\DateConfigurationService;
use Symfony\Component\Form\FormInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormBuilderInterface;
use App\EventSubscriber\DateValidationSubscriber;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class ElevesType extends AbstractType
{
    private array $niveaux = [];

    public function __construct(
        private Security $security,
        private PeresRepository $peresRepository,
        private MeresRepository $meresRepository,
        private StatutsRepository $statutsRepository,
        private NiveauxRepository $niveauxRepository,
        private LoggerInterface $logger,
        private Scolarites2Repository $scolarites2Repository,
        private DateConfigurationService $dateConfigurationService,
    ) {
        $user = $this->security->getUser();
        if ($user instanceof Users) {
            $etablissement = $user->getEtablissement();
            $this->niveaux = $this->niveauxRepository->findByEtablissement($etablissement);
            $this->logger->info('Niveaux chargés', ['niveaux' => $this->niveaux]);
            $this->dateConfigurationService = $dateConfigurationService;
        }
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sexe', ChoiceType::class, [
                'expanded' => true,
                'multiple' => false,
                'choices' => [
                    'Masculin' => 'M',
                    'Féminin' => 'F',
                ],
                'label_attr' => [
                    'class' => 'radio-inline'
                ],
                'row_attr' => [
                    'class' => 'radio-inline-container'
                ],
            ])
            ->add('statutFinance', ChoiceType::class, [
                'expanded' => true,
                'multiple' => false,
                'choices' => [
                    'Privé(e)' => 'P',
                    'Boursier(ère)' => 'B',
                    'Exonoré(e)' => 'E'
                ],
                'label_attr' => [
                    'class' => 'radio-inline'
                ],
                'row_attr' => [
                    'class' => 'radio-inline-container'
                ],
            ])
            ->add('nom', EntityType::class, [
                'class' => Noms::class,
                'placeholder' => 'Entrer ou Choisir un Nom',
                'choice_label' => 'designation',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('n')
                        ->orderBy('n.designation', 'ASC')
                        ->setCacheable(true);
                },
                'attr' => [
                    'class' => 'select-nomfamille'
                ],
                'error_bubbling' => false,
            ])
            ->add('prenom', EntityType::class, [
                'class' => Prenoms::class,
                'choice_label' => 'designation',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.designation', 'ASC')
                        ->setCacheable(true);
                },
                'placeholder' => 'Entrer ou Choisir un prénom',
                'attr' => [
                    'class' => 'select-prenom'
                ],
                'error_bubbling' => false,
            ])
            ->add('isActif', CheckboxType::class, [
                'label' => 'Actif(ve)',
                'required' => false,
            ])
            ->add('isAllowed', CheckboxType::class, [
                'label' => 'Autorisé(e)',
                'required' => false,
            ])
            ->add('isAdmin', CheckboxType::class, [
                'label' => 'Admis(e)',
                'required' => false,
            ])
            ->add('isHandicap', CheckboxType::class, [
                'label' => 'Handicapé(e)',
                'required' => false,
            ])
            ->add('natureHandicape', TextType::class, [
                'attr' => ['placeholder' => "Nature handicape"],
                'required' => false,
            ])
            ->add('parent', EntityType::class, [
                'class' => Parents::class,
                'choice_label' => 'id',
            ])
            ->add('numeroExtrait', TextType::class, [
                'attr' => ['placeholder' => "Numéro Extrait de Naissance"],
                'error_bubbling' => false,
            ])
            ->add('region', EntityType::class, [
                'class' => Regions::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('r')
                        ->orderBy('r.designation', 'ASC')
                        ->setCacheable(true);
                },
                'choice_label' => 'designation',
                'label' => 'Région',
                'placeholder' => 'Choisir la Région',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'class' => 'select-region'
                ],
            ])
            ->add('niveau', EntityType::class, [
                'class' => Niveaux::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('n')
                        ->orderBy('n.designation', 'ASC')
                        ->setCacheable(true);
                },
                'choice_label' => 'designation',
                'label' => 'Niveau',
                'choices' => $this->niveaux,
                'placeholder' => 'Choisir le Niveau',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'class' => 'select-niveau'
                ],
            ])
        ;

        // Écouteurs d'événements pour les champs dynamiques
        $builder->get('region')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $data = $form->getData();
                $this->addCerclesField($form->getParent(), $data);
            }
        );

        $builder->get('niveau')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $data = $form->getData();
                dump($form, $data);
                $this->addClassesField($form->getParent(), $data);
                $this->addScolarites1Field($form->getParent(), $data);
                $this->addDatesField($form->getParent(), $data);
                $isNewRegistration = !$form->getParent()->getData()->getId(); // Assuming getId() returns the ID of the entity

                ($this->addStatutsField($form->getParent(), $form->getData(), $isNewRegistration));
            }
        );

        $builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $event) {
                $data = $event->getData();
                /**@LieuNaissances $lieuNaissance */
                $lieuNaissance = $data->getLieuNaissance();
                $form = $event->getForm();
                if ($lieuNaissance) {
                    $commune = $lieuNaissance->getCommune();
                    $cercle = $commune->getCercle();
                    $region = $cercle->getRegion();
                    $this->addCerclesField($form, $region);
                    $this->addCommunesField($form, $cercle);
                    $this->addLieuNaissanceField($form, $commune);
                    $form->get('region')->setData($region);
                    $form->get('cercle')->setData($cercle);
                    $form->get('commune')->setData($commune);
                } else {
                    $this->addCerclesField($form, null);
                    $this->addCommunesField($form, null);
                    $this->addLieuNaissanceField($form, null);
                }
            }
        );

        // Attache l'EventSubscriber pour la validation des dates
        $builder->addEventSubscriber(new DateValidationSubscriber());
    }

    public function addCerclesField(FormInterface $form, ?Regions $regions)
    {
        $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
            'cercle',
            EntityType::class,
            null,
            [
                'class' => Cercles::class,
                'choice_label' => 'designation',
                'auto_initialize' => false,
                'label' => 'Cercle de :',
                'choices' => $regions ? $regions->getCercles() : [],
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.designation', 'ASC');
                },
                'placeholder' => $regions ? 'Entrer ou Choisir un Cercle' : 'Entrer ou Choisir une Région',
                'attr' => [
                    'class' => 'select-cercle'
                ],
                /*'constraints' => [
                    new Assert\NotBlank(),
                ],*/
                'required' => false,
                'mapped' => false,
                'error_bubbling' => false,
            ]
        );

        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $data = $form->getData();
                $this->addCommunesField($form->getParent(), $form->getData());
            }
        );

        $form->add($builder->getForm());
    }

    public function addCommunesField(FormInterface $form, ?Cercles $cercles)
    {
        $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
            'commune',
            EntityType::class,
            null,
            [
                'class' => Communes::class,
                'choice_label' => 'designation',
                'label' => 'Commune de :',
                'auto_initialize' => false,
                'choices' => $cercles ? $cercles->getCommunes() : [],
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.designation', 'ASC');
                },
                'placeholder' => $cercles ? 'Entrer ou Choisir une Commune' : 'Entrer ou Choisir un Cercle',
                'attr' => [
                    'class' => 'select-commune'
                ],
                /*'constraints' => [
                    new Assert\NotBlank(),
                ],*/
                'required' => false,
                'mapped' => false,
                'error_bubbling' => false,
            ]
        );

        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $data = $form->getData();
                $this->addLieuNaissanceField($form->getParent(), $form->getData());
            }
        );

        $form->add($builder->getForm());
    }

    public function addLieuNaissanceField(FormInterface $form, ?Communes $communes)
    {
        $form->add('lieuNaissance', EntityType::class, [
            'class' => LieuNaissances::class,
            'choice_label' => 'designation',
            'choices' => $communes ? $communes->getLieuNaissances() : [],
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('l')
                    ->orderBy('l.designation', 'ASC');
            },
            'placeholder' => $communes ? 'Entrer ou Choisir le lieu de Naissance' : 'Entrer ou Choisir la Commune',
            'attr' => [
                'class' => 'select-lieu'
            ],
            'required' => false,
            'error_bubbling' => false,
        ]);
    }

    public function addClassesField(FormInterface $form, ?Niveaux $niveaux)
    {
        $form->add('classe', EntityType::class, [
            'class' => Classes::class,
            'choice_label' => 'designation',
            'choices' => $niveaux ? $niveaux->getClasses() : [],
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('c')
                    ->orderBy('c.designation', 'ASC');
            },
            'placeholder' => $niveaux ? 'Entrer ou Choisir la classe' : 'Entrer ou Choisir le niveau',
            'attr' => [
                'class' => 'select-classe'
            ],
            'required' => false,
            'error_bubbling' => false,
        ]);
    }

    public function addStatutsField(FormInterface $form, ?Niveaux $niveaux, bool $isNewRegistration): void
    {
        $statutsForRegistration = $this->statutsRepository->findStatutsForNlEnregistrement($niveaux);
        if ($isNewRegistration) {
            $form->add('statut', EntityType::class, [
                'label' => 'Statut',
                'class' => Statuts::class,
                'choices' => $statutsForRegistration ? $statutsForRegistration : [],
                'placeholder' => 'Entrer ou Choisir un statut',
                'choice_label' => 'designation',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.designation', 'ASC');
                },
                'attr' => [
                    'class' => 'select-statut'
                ],
                'error_bubbling' => false,
            ]);
        } else {
            $form->add('statut', EntityType::class, [
                'label' => 'Statut',
                'class' => Statuts::class,
                'choices' => $niveaux ? $niveaux->getStatuts() : [],
                'placeholder' => 'Entrer ou Choisir un statut',
                'choice_label' => 'designation',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.designation', 'ASC');
                },
                'attr' => [
                    'class' => 'select-statut'
                ],
                'error_bubbling' => false,
            ]);
        }
    }

    public function addScolarites1Field(FormInterface $form, ?Niveaux $niveaux)
    {
        $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
            'scolarite1',
            EntityType::class,
            null,
            [
                'class' => Scolarites1::class,
                'choice_label' => 'scolarite',
                'label' => 'Scolarité 1er Cy :',
                'auto_initialize' => false,
                'choices' => $niveaux ? $niveaux->getScolarites1s() : [],
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.scolarite', 'ASC');
                },
                'placeholder' => $niveaux ? '** ** ' : '## ##',
                'attr' => [
                    'class' => 'select-scolarite'
                ],
                /*'constraints' => [
                new Assert\NotBlank(),
            ],*/
                'required' => false,
                'mapped' => false,
                'error_bubbling' => false,
            ]
        );
        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $data = $form->getData();
                $this->addScolarites2Field($form->getParent(), $form->getData());
            }
        );

        $form->add($builder->getForm());
    }

    public function addScolarites2Field(FormInterface $form, ?Scolarites1 $scolarites1)
    {
        $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
            'scolarite2',
            EntityType::class,
            null,
            [
                'class' => Scolarites2::class,
                'choice_label' => 'scolarite',
                'label' => 'Scolarité 2nd Cycle :',
                'auto_initialize' => false,
                'choices' => $scolarites1 ? $scolarites1->getScolarites2s() : [],
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.scolarite', 'ASC');
                },
                'placeholder' => $scolarites1 ? '** ** ' : '## ##',
                'attr' => [
                    'class' => 'select-scolarite'
                ],
                /*'constraints' => [
                new Assert\NotBlank(),
            ],*/
                'required' => false,
                'mapped' => false,
                'error_bubbling' => false,
            ]
        );
        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $data = $form->getData();
                //$this->addScolarites2Field($form->getParent(), $form->getData());
            }
        );

        $form->add($builder->getForm());
    }

    public function addDatesField(FormInterface $form, ?Niveaux $niveaux): void
    {
        if (!$niveaux) {
            // Ajoutez les champs par défaut si aucun niveau n'est sélectionné
            $this->addDateFields($form, [
                'dateInscription' => ['min' => '-1 year', 'max' => 'now'],
                'dateRecrutement' => ['min' => '-1 year', 'max' => '-1 day'],
                'dateNaissance' => ['min' => '-4 years', 'max' => '-3 years'],
                'dateExtrait' => ['min' => '-1 year', 'max' => '-1 day'],
            ]);
            return;
        }

        $designation = $niveaux->getDesignation();
        $configurations = $this->getDateConfigurations();

        if (isset($configurations[$designation])) {
            $this->addDateFields($form, $configurations[$designation]);
            //$this->addCustomValidation($form);
        }
    }

    private function addDateFields(FormInterface $form, array $config): void
    {
        foreach ($config as $field => $dates) {
            $form->add($field, DateType::class, [
                'label' => ucfirst(str_replace('date', 'Date ', $field)),
                'widget' => 'single_text',
                'auto_initialize' => false,
                'attr' => [
                    'min' => (new \DateTime($dates['min']))->format('Y-m-d'),
                    'max' => (new \DateTime($dates['max']))->format('Y-m-d'),
                ],
                'constraints' => [
                    new NotNull([
                        'message' => 'Ce champ est obligatoire.',
                    ]),
                ],
            ]);
        }
    }

    private function getDateConfigurations(): array
    {
        return $this->dateConfigurationService->getDateConfigurations();
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Eleves::class,
        ]);
    }
}
