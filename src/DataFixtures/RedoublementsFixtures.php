<?php

namespace App\DataFixtures;

use App\Entity\Redoublements1;
use App\Entity\Redoublements2;
use App\Entity\Redoublements3;
use App\Repository\NiveauxRepository;
use Doctrine\Persistence\ObjectManager;
use App\Repository\Scolarites1Repository;
use App\Repository\Scolarites2Repository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class RedoublementsFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private NiveauxRepository $niveauxRepository,
        private Scolarites1Repository $scolarites1Repository,
        private Scolarites2Repository $scolarites2Repository
    ) {}
    public function load(ObjectManager $manager): void
    {
        $niveaux = $this->niveauxRepository->findAll();
        foreach ($niveaux as $niveau) {
            $niveauDesignation = $niveau->getDesignation();
            $niveau1ere = $this->niveauxRepository->findOneBy(['designation' => '1ère Année']);
            $niveau2eme = $this->niveauxRepository->findOneBy(['designation' => '2ème Année']);
            $niveau3eme = $this->niveauxRepository->findOneBy(['designation' => '3ème Année']);
            $niveau4eme = $this->niveauxRepository->findOneBy(['designation' => '4ème Année']);
            $niveau5eme = $this->niveauxRepository->findOneBy(['designation' => '5ème Année']);
            $niveau6eme = $this->niveauxRepository->findOneBy(['designation' => '6ème Année']);
            $niveau7eme = $this->niveauxRepository->findOneBy(['designation' => '7ème Année']);
            $niveau8eme = $this->niveauxRepository->findOneBy(['designation' => '8ème Année']);
            $niveau9eme = $this->niveauxRepository->findOneBy(['designation' => '9ème Année']);
            $scolarites1 = $this->scolarites1Repository->findBy(['niveau' => $niveau]);
            foreach ($scolarites1 as $scolarite1) {
                $scolarites2 = $this->scolarites2Repository->findBy(['scolarite1' => $scolarite1]);
                $scolaritee1 = $scolarite1->getScolarite();
                foreach ($scolarites2 as $scolarite2) {
                    $scolaritee2 = $scolarite2->getScolarite();
                    //niveau 1ère année 1er Redoublement
                    if ($niveauDesignation === '1ère Année' && $scolaritee1 == 2 && $scolaritee2 == 0) {
                        $redoublement1 = new Redoublements1();
                        $redoublement1->setNiveau($niveau1ere);
                        $redoublement1->addScolarites1($scolarite1);
                        $redoublement1->addScolarites2($scolarite2);

                        $manager->persist($redoublement1);

                        // niveau 1ère Annéé 2ème redoublement;
                    } elseif ($niveauDesignation === '1ère Année' && $scolaritee1 == 3 && $scolaritee2 == 0) {
                        //1er redoublement en 1ère année
                        $redoublement1 = new Redoublements1();
                        $redoublement1->setNiveau($niveau1ere);
                        $redoublement1->addScolarites1($scolarite1);
                        $redoublement1->addScolarites2($scolarite2);
                        for ($i = 0; $i < 2; $i++) {
                            //2ème redoublement en 1ère année
                            $redoublement2 = new Redoublements2();
                            $redoublement2->setNiveau($niveau1ere);
                            $redoublement2->setRedoublement1($redoublement1);
                            $redoublement2->addScolarites1($scolarite1);
                            $redoublement2->addScolarites2($scolarite2);
                            $manager->persist($redoublement2);
                        }
                        $manager->persist($redoublement1);
                    } elseif ($niveauDesignation === '2ème Année' && $scolaritee1 == 3 && $scolaritee2 == 0) {
                        for ($i = 0; $i < 2; $i++) {
                            //redoublement 2ème année
                            if ($i == 0) {
                                //1er redoublement 1ère année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau1ere);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                $manager->persist($redoublement1);
                            } elseif ($i == 1) {
                                //1er reoublement 2ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau2eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                $manager->persist($redoublement1);
                            }
                        }
                    } elseif ($niveauDesignation === '2ème Année' && $scolaritee1 == 4 && $scolaritee2 == 0) {
                        for ($a = 0; $a < 3; $a++) {
                            //redoublement 2ème année
                            if ($a == 0) {
                                //1er redoublement 1ère année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau1ere);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                //2ème redoublement 2ème année
                                $redoublement2 = new Redoublements2();
                                $redoublement2->setNiveau($niveau2eme);
                                $redoublement2->setRedoublement1($redoublement1);
                                $redoublement2->addScolarites1($scolarite1);
                                $redoublement2->addScolarites2($scolarite2);
                                $manager->persist($redoublement2);
                                $manager->persist($redoublement1);
                            } elseif ($a == 1) {
                                //1er reoublement 2ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau2eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                //2ème redoublement 2ème année
                                $redoublement2 = new Redoublements2();
                                $redoublement2->setNiveau($niveau2eme);
                                $redoublement2->setRedoublement1($redoublement1);
                                $redoublement2->addScolarites1($scolarite1);
                                $redoublement2->addScolarites2($scolarite2);
                                $manager->persist($redoublement2);
                                $manager->persist($redoublement1);
                            }
                        }
                    } elseif ($niveauDesignation === '2ème Année' && $scolaritee1 == 5 && $scolaritee2 == 0) {

                        //1er redoublement 1ère année
                        $redoublement1 = new Redoublements1();
                        $redoublement1->setNiveau($niveau1ere);
                        $redoublement1->addScolarites1($scolarite1);
                        $redoublement1->addScolarites2($scolarite2);
                        //2ème redoublement 2ème année
                        $redoublement2 = new Redoublements2();
                        $redoublement2->setNiveau($niveau2eme);
                        $redoublement2->setRedoublement1($redoublement1);
                        $redoublement2->addScolarites1($scolarite1);
                        $redoublement2->addScolarites2($scolarite2);
                        //3ème redoublement 2ème année
                        $redoublement3 = new Redoublements3();
                        $redoublement3->setNiveau($niveau2eme);
                        $redoublement3->setRedoublement2($redoublement2);
                        $redoublement3->addScolarites1($scolarite1);
                        $redoublement3->addScolarites2($scolarite2);
                        $manager->persist($redoublement3);
                        $manager->persist($redoublement2);
                        $manager->persist($redoublement1);
                    } elseif ($niveauDesignation === '3ème Année' && $scolaritee1 == 4 && $scolaritee2 == 0) {
                        for ($i = 0; $i < 3; $i++) {
                            //redoublement 3ème année
                            if ($i == 0) {
                                //1er redoublement 1ère année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau1ere);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                $manager->persist($redoublement1);
                            } elseif ($i == 1) {
                                //1er reoublement 2ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau2eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                $manager->persist($redoublement1);
                            } elseif ($i == 2) {
                                //1er reoublement 3ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau3eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                $manager->persist($redoublement1);
                            }
                        }
                    } elseif ($niveauDesignation === '3ème Année' && $scolaritee1 == 5 && $scolaritee2 == 0) {
                        for ($a = 0; $a < 3; $a++) {
                            //redoublement 3ème année
                            if ($a == 0) {
                                //1er redoublement 1ère année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau1ere);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($b = 0; $b < 2; $b++) {
                                    if ($b == 0) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau2eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);

                                    } else {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau3eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);

                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($a == 1) {
                                //1er reoublement 2ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau2eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($b = 0; $b < 1; $b++) {
                                    $redoublement2 = new Redoublements2();
                                    $redoublement2->setNiveau($niveau3eme);
                                    $redoublement2->setRedoublement1($redoublement1);
                                    $redoublement2->addScolarites1($scolarite1);
                                    $redoublement2->addScolarites2($scolarite2);
                                    $manager->persist($redoublement2);

                                }
                                $manager->persist($redoublement1);
                            } elseif ($a == 2) {
                                //1er reoublement 3ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau3eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($b = 0; $b < 1; $b++) {
                                    $redoublement2 = new Redoublements2();
                                    $redoublement2->setNiveau($niveau3eme);
                                    $redoublement2->setRedoublement1($redoublement1);
                                    $redoublement2->addScolarites1($scolarite1);
                                    $redoublement2->addScolarites2($scolarite2);
                                    $manager->persist($redoublement2);

                                }

                                $manager->persist($redoublement1);
                            }
                        }
                    } elseif ($niveauDesignation === '3ème Année' && $scolaritee1 == 6 && $scolaritee2 == 0) {
                        //redoublement 3ème année
                        //1er redoublement 1ère année
                        $redoublement1 = new Redoublements1();
                        $redoublement1->setNiveau($niveau1ere);
                        $redoublement1->addScolarites1($scolarite1);
                        $redoublement1->addScolarites2($scolarite2);
                        $redoublement2 = new Redoublements2();
                        $redoublement2->setNiveau($niveau2eme);
                        $redoublement2->setRedoublement1($redoublement1);
                        $redoublement2->addScolarites1($scolarite1);
                        $redoublement2->addScolarites2($scolarite2);
                        $redoublement3 = new Redoublements3();
                        $redoublement3->setNiveau($niveau3eme);
                        $redoublement3->setRedoublement2($redoublement2);
                        $redoublement3->addScolarites1($scolarite1);
                        $redoublement3->addScolarites2($scolarite2);
                        $manager->persist($redoublement3);
                        $manager->persist($redoublement2);
                        $manager->persist($redoublement1);
                    } elseif ($niveauDesignation === '4ème Année' && $scolaritee1 == 5 && $scolaritee2 == 0) {
                        for ($i = 0; $i < 4; $i++) {
                            //redoublement 3ème année
                            if ($i == 0) {
                                //1er redoublement 1ère année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau1ere);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                $manager->persist($redoublement1);
                            } elseif ($i == 1) {
                                //1er reoublement 2ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau2eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                $manager->persist($redoublement1);
                            } elseif ($i == 2) {
                                //1er reoublement 3ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau3eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                $manager->persist($redoublement1);
                            } elseif ($i == 3) {
                                //1er reoublement 3ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau4eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                $manager->persist($redoublement1);
                            }
                        }
                    } elseif ($niveauDesignation === '4ème Année' && $scolaritee1 == 6 && $scolaritee2 == 0) {
                        for ($i = 0; $i < 4; $i++) {
                            //redoublement 3ème année
                            if ($i == 0) {
                                //1er redoublement 1ère année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau1ere);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 3; $a++) {
                                    if ($a == 0) {
                                        //2ème redoublement 2ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau2eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        //2ème redoublement 2ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau3eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    } elseif ($a == 2) {
                                        //2ème redoublement 2ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau4eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 1) {
                                //1er reoublement 2ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau2eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 2; $a++) {
                                    if ($a == 0) {
                                        //2ème redoublement 3ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau3eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        //2ème redoublement 4ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau4eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 2) {
                                //1er reoublement 3ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau3eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 1; $a++) {
                                    if ($a == 0) {
                                        //2ème redoublement 4ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau4eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 3) {
                                //1er redoublement 4ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau4eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                //2ème redoublement 4ème année
                                $redoublement2 = new Redoublements2();
                                $redoublement2->setNiveau($niveau4eme);
                                $redoublement2->setRedoublement1($redoublement1);
                                $redoublement2->addScolarites1($scolarite1);
                                $redoublement2->addScolarites2($scolarite2);
                                $manager->persist($redoublement2);
                                $manager->persist($redoublement1);
                            }
                        }
                    } elseif ($niveauDesignation === '4ème Année' && $scolaritee1 == 7 && $scolaritee2 == 0) {
                        for ($i = 0; $i < 4; $i++) {
                            //redoublement 3ème année
                            if ($i == 0) {
                                //1er redoublement 1ère année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau1ere);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 3; $a++) {
                                    if ($a == 0) {
                                        //2ème redoublement 2ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau2eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        //3ème redoublement 4ème année
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau4eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        //2ème redoublement 2ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau3eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        //3ème redoublement 4ème année
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau4eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 2) {
                                        //2ème redoublement 4ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau4eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        //3ème redoublement 4ème année
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau4eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 1) {
                                //1er reoublement 2ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau2eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 2; $a++) {
                                    if ($a == 0) {
                                        //2ème redoublement 3ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau3eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        //3ème redoublement 4ème année
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau4eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        //2ème redoublement 4ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau4eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        //3ème redoublement 4ème année
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau4eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 2) {
                                //1er reoublement 3ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau3eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 1; $a++) {
                                    if ($a == 0) {
                                        //2ème redoublement 4ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau4eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        //3ème redoublement 4ème année
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau4eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            }
                        }
                    } elseif ($niveauDesignation === '5ème Année' && $scolaritee1 == 6 && $scolaritee2 == 0) {
                        for ($i = 0; $i < 5; $i++) {
                            //redoublement 3ème année
                            if ($i == 0) {
                                //1er redoublement 1ère année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau1ere);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                $manager->persist($redoublement1);
                            } elseif ($i == 1) {
                                //1er reoublement 2ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau2eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                $manager->persist($redoublement1);
                            } elseif ($i == 2) {
                                //1er reoublement 3ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau3eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                $manager->persist($redoublement1);
                            } elseif ($i == 3) {
                                //1er reoublement 4ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau4eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                $manager->persist($redoublement1);
                            } elseif ($i == 4) {
                                //1er reoublement 5ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau5eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                $manager->persist($redoublement1);
                            }
                        }
                    } elseif ($niveauDesignation === '5ème Année' && $scolaritee1 == 7 && $scolaritee2 == 0) {
                        for ($i = 0; $i < 5; $i++) {
                            //redoublement 3ème année
                            if ($i == 0) {
                                //1er redoublement 1ère année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau1ere);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 4; $a++) {
                                    if ($a == 0) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau2eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau3eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    } elseif ($a == 2) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau4eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    } elseif ($a == 3) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau5eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 1) {
                                //1er reoublement 2ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau2eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 3; $a++) {
                                    if ($a == 0) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau3eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau4eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    } elseif ($a == 2) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau5eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 2) {
                                //1er reoublement 3ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau3eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 2; $a++) {
                                    if ($a == 0) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau4eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau5eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 3) {
                                //1er reoublement 4ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau4eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 1; $a++) {
                                    if ($a == 0) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau5eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 4) {
                                //1er reoublement 5ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau5eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                $redoublement2 = new Redoublements2();
                                $redoublement2->setNiveau($niveau5eme);
                                $redoublement2->setRedoublement1($redoublement1);
                                $redoublement2->addScolarites1($scolarite1);
                                $redoublement2->addScolarites2($scolarite2);
                                $manager->persist($redoublement2);

                                $manager->persist($redoublement1);
                            }
                        }
                    } elseif ($niveauDesignation === '5ème Année' && $scolaritee1 == 8 && $scolaritee2 == 0) {
                        for ($i = 0; $i < 4; $i++) {
                            //redoublement 3ème année
                            if ($i == 0) {
                                //1er redoublement 1ère année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau1ere);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 4; $a++) {
                                    if ($a == 0) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau2eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau5eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau3eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau5eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 2) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau4eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau5eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 3) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau5eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau5eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 1) {
                                //1er reoublement 2ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau2eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 3; $a++) {
                                    if ($a == 0) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau3eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau5eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau4eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau5eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 2) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau5eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau5eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 2) {
                                //1er reoublement 3ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau3eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 2; $a++) {
                                    if ($a == 0) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau4eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau5eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau5eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau5eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 3) {
                                //1er reoublement 4ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau4eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 1; $a++) {
                                    if ($a == 0) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau5eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau5eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            }
                        }
                    } elseif ($niveauDesignation === '6ème Année' && $scolaritee1 == 7 && $scolaritee2 == 0) {
                        for ($i = 0; $i < 6; $i++) {
                            //redoublement 3ème année
                            if ($i == 0) {
                                //1er redoublement 1ère année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau1ere);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                $manager->persist($redoublement1);
                            } elseif ($i == 1) {
                                //1er reoublement 2ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau2eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                $manager->persist($redoublement1);
                            } elseif ($i == 2) {
                                //1er reoublement 3ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau3eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                $manager->persist($redoublement1);
                            } elseif ($i == 3) {
                                //1er reoublement 4ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau4eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                $manager->persist($redoublement1);
                            } elseif ($i == 4) {
                                //1er reoublement 5ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau5eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                $manager->persist($redoublement1);
                            } elseif ($i == 4) {
                                //1er reoublement 6ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau6eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                $manager->persist($redoublement1);
                            }
                        }
                    } elseif ($niveauDesignation === '6ème Année' && $scolaritee1 == 8 && $scolaritee2 == 0) {
                        for ($i = 0; $i < 6; $i++) {
                            //redoublement 6ème année
                            if ($i == 0) {
                                //1er redoublement 1ère année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau1ere);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 5; $a++) {
                                    if ($a == 0) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau2eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau3eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    } elseif ($a == 2) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau4eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    } elseif ($a == 3) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau5eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    } elseif ($a == 4) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau6eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 1) {
                                //1er reoublement 2ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau2eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 4; $a++) {
                                    if ($a == 0) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau3eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau4eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    } elseif ($a == 2) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau5eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    } elseif ($a == 3) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau6eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 2) {
                                //1er reoublement 3ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau3eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 3; $a++) {
                                    if ($a == 0) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau4eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau5eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    } elseif ($a == 2) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau6eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 3) {
                                //1er reoublement 4ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau4eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 2; $a++) {
                                    if ($a == 0) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau5eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau6eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 4) {
                                //1er reoublement 5ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau5eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 1; $a++) {
                                    if ($a == 0) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau6eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 4) {
                                //1er reoublement 6ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau6eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 1; $a++) {
                                    if ($a == 0) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau6eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            }
                        }
                    } elseif ($niveauDesignation === '6ème Année' && $scolaritee1 == 9 && $scolaritee2 == 0) {
                        for ($i = 0; $i < 6; $i++) {
                            //redoublement 6ème année
                            if ($i == 0) {
                                //1er redoublement 1ère année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau1ere);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 5; $a++) {
                                    if ($a == 0) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau2eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau6eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau3eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau6eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 2) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau4eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau6eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 3) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau5eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau6eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 4) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau6eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau6eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 1) {
                                //1er reoublement 2ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau2eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 4; $a++) {
                                    if ($a == 0) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau3eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau6eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau4eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau6eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 2) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau5eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau6eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 3) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau6eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau6eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 2) {
                                //1er reoublement 3ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau3eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 3; $a++) {
                                    if ($a == 0) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau4eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau6eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau5eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau6eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 2) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau6eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau6eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 3) {
                                //1er reoublement 4ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau4eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 2; $a++) {
                                    if ($a == 0) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau5eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau6eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau6eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau6eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 4) {
                                //1er reoublement 5ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau5eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 1; $i++) {
                                    if ($a == 0) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau6eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau6eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            }
                        }
                    } elseif ($niveauDesignation === '7ème Année' && $scolaritee1 == 6 && $scolaritee2 == 2) {
                        //1er redoublement 7ème année
                        $redoublement1 = new Redoublements1();
                        $redoublement1->setNiveau($niveau7eme);
                        $redoublement1->addScolarites1($scolarite1);
                        $redoublement1->addScolarites2($scolarite2);
                        $manager->persist($redoublement1);
                    } elseif ($niveauDesignation === '7ème Année' && $scolaritee1 == 6 && $scolaritee2 == 3) {
                        //1er redoublement 7ème année
                        $redoublement1 = new Redoublements1();
                        $redoublement1->setNiveau($niveau7eme);
                        $redoublement1->addScolarites1($scolarite1);
                        $redoublement1->addScolarites2($scolarite2);
                        //2ème redoublement 7ème année
                        $redoublement2 = new Redoublements2();
                        $redoublement2->setNiveau($niveau7eme);
                        $redoublement2->setRedoublement1($redoublement1);
                        $redoublement2->addScolarites1($scolarite1);
                        $redoublement2->addScolarites2($scolarite2);
                        $manager->persist($redoublement2);

                        $manager->persist($redoublement1);
                    } elseif ($niveauDesignation === '7ème Année' && $scolaritee1 == 7 && $scolaritee2 == 2) {
                        for ($i = 0; $i < 6; $i++) {
                            //redoublement 3ème année
                            if ($i == 0) {
                                //1er redoublement 1ère année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau1ere);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 1; $a++) {
                                    if ($a == 0) {
                                        //2ème redoublement 7ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau7eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 1) {
                                //1er reoublement 2ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau2eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 1; $a++) {
                                    if ($a == 0) {
                                        //2ème redoublement 7ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau7eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 2) {
                                //1er reoublement 3ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau3eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 1; $a++) {
                                    if ($a == 0) {
                                        //2ème redoublement 7ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau7eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 3) {
                                //1er reoublement 4ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau4eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 1; $a++) {
                                    if ($a == 0) {
                                        //2ème redoublement 7ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau7eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 4) {
                                //1er reoublement 5ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau5eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 1; $a++) {
                                    if ($a == 0) {
                                        //2ème redoublement 7ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau7eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 4) {
                                //1er reoublement 6ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau6eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 1; $a++) {
                                    if ($a == 0) {
                                        //2ème redoublement 7ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau7eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            }
                        }
                    } elseif ($niveauDesignation === '7ème Année' && $scolaritee1 == 7 && $scolaritee2 == 3) {
                        for ($i = 0; $i < 6; $i++) {
                            //redoublement 3ème année
                            if ($i == 0) {
                                //1er redoublement 1ère année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau1ere);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 1; $a++) {
                                    if ($a == 0) {
                                        //2ème redoublement 7ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau7eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        //3ème redoublement 7ème année
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau7eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);
                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 1) {
                                //1er reoublement 2ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau2eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 1; $a++) {
                                    if ($a == 0) {
                                        //2ème redoublement 7ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau7eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        //3ème redoublement 7ème année
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau7eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 2) {
                                //1er reoublement 3ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau3eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 1; $a++) {
                                    if ($a == 0) {
                                        //2ème redoublement 7ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau7eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        //3ème redoublement 7ème année
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau7eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 3) {
                                //1er reoublement 4ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau4eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 1; $a++) {
                                    if ($a == 0) {
                                        //2ème redoublement 7ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau7eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        //3ème redoublement 7ème année
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau7eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 4) {
                                //1er reoublement 5ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau5eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 1; $a++) {
                                    if ($a == 0) {
                                        //2ème redoublement 7ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau7eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        //3ème redoublement 7ème année
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau7eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 4) {
                                //1er reoublement 6ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau6eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 1; $a++) {
                                    if ($a == 0) {
                                        //2ème redoublement 7ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau7eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        //3ème redoublement 7ème année
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau7eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            }
                        }
                    } elseif ($niveauDesignation === '7ème Année' && $scolaritee1 == 8 && $scolaritee2 == 2) {
                        for ($i = 0; $i < 6; $i++) {
                            //redoublement 6ème année
                            if ($i == 0) {
                                //1er redoublement 1ère année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau1ere);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 5; $a++) {
                                    if ($a == 0) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau2eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau7eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau3eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau7eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 2) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau4eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau7eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 3) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau5eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau7eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 4) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau6eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau7eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 1) {
                                //1er reoublement 2ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau2eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 4; $a++) {
                                    if ($a == 0) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau3eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau7eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau4eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau7eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 2) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau5eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau7eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 3) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau6eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau7eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 2) {
                                //1er reoublement 3ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau3eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 3; $a++) {
                                    if ($a == 0) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau4eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau7eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau5eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    } elseif ($a == 2) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau6eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau7eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 3) {
                                //1er reoublement 4ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau4eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 2; $a++) {
                                    if ($a == 0) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau5eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau7eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau6eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau7eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 4) {
                                //1er reoublement 5ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau5eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 1; $a++) {
                                    if ($a == 0) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau6eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau7eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 4) {
                                //1er reoublement 6ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau6eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 1; $a++) {
                                    if ($a == 0) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau6eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau7eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            }
                        }
                    } elseif ($niveauDesignation === '8ème Année' && $scolaritee1 == 6 && $scolaritee2 == 3) {
                        //1er redoublement 7ème année
                        for ($i = 0; $i < 2; $i++) {
                            if ($i == 0) {
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau7eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                $manager->persist($redoublement1);
                            } else {
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau8eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                $manager->persist($redoublement1);
                            }
                        }
                    } elseif ($niveauDesignation === '8ème Année' && $scolaritee1 == 6 && $scolaritee2 == 4) {
                        //1er redoublement 7ème année
                        for ($i = 0; $i < 2; $i++) {
                            if ($i == 0) {
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau7eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                $redoublement2 = new Redoublements2();
                                $redoublement2->setNiveau($niveau8eme);
                                $redoublement2->setRedoublement1($redoublement1);
                                $redoublement2->addScolarites1($scolarite1);
                                $redoublement2->addScolarites2($scolarite2);
                                $manager->persist($redoublement2);

                                $manager->persist($redoublement1);
                            } else {
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau8eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                $redoublement2 = new Redoublements2();
                                $redoublement2->setNiveau($niveau8eme);
                                $redoublement2->setRedoublement1($redoublement1);
                                $redoublement2->addScolarites1($scolarite1);
                                $redoublement2->addScolarites2($scolarite2);
                                $manager->persist($redoublement2);

                                $manager->persist($redoublement1);
                            }
                        }
                    } elseif ($niveauDesignation === '8ème Année' && $scolaritee1 == 6 && $scolaritee2 == 5) {
                        //1er redoublement 7ème année
                        for ($i = 0; $i < 2; $i++) {
                            if ($i == 0) {
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau7eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                $redoublement2 = new Redoublements2();
                                $redoublement2->setNiveau($niveau8eme);
                                $redoublement2->setRedoublement1($redoublement1);
                                $redoublement2->addScolarites1($scolarite1);
                                $redoublement2->addScolarites2($scolarite2);
                                $redoublement3 = new Redoublements3();
                                $redoublement3->setNiveau($niveau8eme);
                                $redoublement3->setRedoublement2($redoublement2);
                                $redoublement3->addScolarites1($scolarite1);
                                $redoublement3->addScolarites2($scolarite2);
                                $manager->persist($redoublement3);

                                $manager->persist($redoublement2);

                                $manager->persist($redoublement1);
                            }
                        }
                    } elseif ($niveauDesignation === '8ème Année' && $scolaritee1 == 7 && $scolaritee2 == 3) {
                        for ($i = 0; $i < 6; $i++) {
                            //redoublement 3ème année
                            if ($i == 0) {
                                //1er redoublement 1ère année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau1ere);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 2; $a++) {
                                    if ($a == 0) {
                                        //2ème redoublement 7ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau7eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        //2ème redoublement 8ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau8eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 1) {
                                //1er reoublement 2ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau2eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 2; $a++) {
                                    if ($a == 0) {
                                        //2ème redoublement 7ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau7eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        //2ème redoublement 8ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau8eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 2) {
                                //1er reoublement 3ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau3eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 2; $a++) {
                                    if ($a == 0) {
                                        //2ème redoublement 7ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau7eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        //2ème redoublement 8ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau8eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 3) {
                                //1er reoublement 4ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau4eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 2; $a++) {
                                    if ($a == 0) {
                                        //2ème redoublement 7ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau7eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        //2ème redoublement 8ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau8eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 4) {
                                //1er reoublement 5ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau5eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 2; $a++) {
                                    if ($a == 0) {
                                        //2ème redoublement 7ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau7eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        //2ème redoublement 8ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau8eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 4) {
                                //1er reoublement 6ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau6eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 2; $a++) {
                                    if ($a == 0) {
                                        //2ème redoublement 7ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau7eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        //2ème redoublement 8ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau8eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            }
                        }
                    } elseif ($niveauDesignation === '8ème Année' && $scolaritee1 == 7 && $scolaritee2 == 4) {
                        for ($i = 0; $i < 6; $i++) {
                            //redoublement 3ème année
                            if ($i == 0) {
                                //1er redoublement 1ère année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau1ere);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 2; $a++) {
                                    if ($a == 0) {
                                        //2ème redoublement 7ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau7eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau8eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        //2ème redoublement 8ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau8eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau8eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 1) {
                                //1er reoublement 2ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau2eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 2; $a++) {
                                    if ($a == 0) {
                                        //2ème redoublement 7ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau7eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau8eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        //2ème redoublement 8ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau8eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau8eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 2) {
                                //1er reoublement 3ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau3eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 2; $a++) {
                                    if ($a == 0) {
                                        //2ème redoublement 7ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau7eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau8eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        //2ème redoublement 8ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau8eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau8eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 3) {
                                //1er reoublement 4ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau4eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 2; $a++) {
                                    if ($a == 0) {
                                        //2ème redoublement 7ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau7eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau8eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        //2ème redoublement 8ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau8eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau8eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 4) {
                                //1er reoublement 5ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau5eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 2; $a++) {
                                    if ($a == 0) {
                                        //2ème redoublement 7ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau7eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau8eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        //2ème redoublement 8ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau8eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau8eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 4) {
                                //1er reoublement 6ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau6eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 2; $a++) {
                                    if ($a == 0) {
                                        //2ème redoublement 7ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau7eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau8eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        //2ème redoublement 8ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau8eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau8eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            }
                        }
                    } elseif ($niveauDesignation === '8ème Année' && $scolaritee1 == 8 && $scolaritee2 == 3) {
                        for ($i = 0; $i < 6; $i++) {
                            //redoublement 6ème année
                            if ($i == 0) {
                                //1er redoublement 1ère année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau1ere);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 5; $a++) {
                                    if ($a == 0) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau2eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau8eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau3eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau8eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 2) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau4eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau8eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 3) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau5eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau8eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 4) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau6eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau8eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 1) {
                                //1er reoublement 2ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau2eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 4; $a++) {
                                    if ($a == 0) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau3eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau8eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau4eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau8eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 2) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau5eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau8eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 3) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau6eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau8eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 2) {
                                //1er reoublement 3ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau3eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 3; $a++) {
                                    if ($a == 0) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau4eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau8eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau5eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau8eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 2) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau6eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau8eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 3) {
                                //1er reoublement 4ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau4eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 2; $a++) {
                                    if ($a == 0) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau5eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau8eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau6eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau8eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 4) {
                                //1er reoublement 5ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau5eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 1; $a++) {
                                    if ($a == 0) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau6eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau8eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 4) {
                                //1er reoublement 6ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau6eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 1; $a++) {
                                    if ($a == 0) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau6eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau8eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            }
                        }
                    } elseif ($niveauDesignation === '9ème Année' && $scolaritee1 == 6 && $scolaritee2 == 4) {
                        //1er redoublement 7ème année
                        for ($i = 0; $i < 3; $i++) {
                            if ($i == 0) {
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau7eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                $manager->persist($redoublement1);
                            } elseif ($i == 1) {
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau8eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                $manager->persist($redoublement1);
                            } elseif ($i == 2) {
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau9eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                $manager->persist($redoublement1);
                            }
                        }
                    } elseif ($niveauDesignation === '9ème Année' && $scolaritee1 == 6 && $scolaritee2 == 5) {
                        //1er redoublement 7ème année
                        for ($i = 0; $i < 3; $i++) {
                            if ($i == 0) {
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau7eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 2; $a++) {
                                    if ($a == 0) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau8eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau9eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 1) {
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau8eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                $redoublement2 = new Redoublements2();
                                $redoublement2->setNiveau($niveau9eme);
                                $redoublement2->setRedoublement1($redoublement1);
                                $redoublement2->addScolarites1($scolarite1);
                                $redoublement2->addScolarites2($scolarite2);
                                $manager->persist($redoublement2);

                                $manager->persist($redoublement1);
                            } elseif ($i == 2) {
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau9eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                $redoublement2 = new Redoublements2();
                                $redoublement2->setNiveau($niveau9eme);
                                $redoublement2->setRedoublement1($redoublement1);
                                $redoublement2->addScolarites1($scolarite1);
                                $redoublement2->addScolarites2($scolarite2);
                                $manager->persist($redoublement2);

                                $manager->persist($redoublement1);
                            }
                        }
                    } elseif ($niveauDesignation === '9ème Année' && $scolaritee1 == 6 && $scolaritee2 == 6) {
                        //1er redoublement 7ème année
                        for ($i = 0; $i < 2; $i++) {
                            if ($i == 0) {
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau7eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 2; $a++) {
                                    if ($a == 0) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau8eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau9eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau9eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau9eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            }
                        }
                    } elseif ($niveauDesignation === '9ème Année' && $scolaritee1 == 7 && $scolaritee2 == 4) {
                        for ($i = 0; $i < 6; $i++) {
                            //redoublement 3ème année
                            if ($i == 0) {
                                //1er redoublement 1ère année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau1ere);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 3; $a++) {
                                    if ($a == 0) {
                                        //2ème redoublement 7ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau7eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        //2ème redoublement 8ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau8eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    } elseif ($a == 2) {
                                        //2ème redoublement 8ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau9eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 1) {
                                //1er reoublement 2ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau2eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 3; $a++) {
                                    if ($a == 0) {
                                        //2ème redoublement 7ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau7eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        //2ème redoublement 8ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau8eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    } elseif ($a == 2) {
                                        //2ème redoublement 8ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau9eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 2) {
                                //1er reoublement 3ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau3eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 3; $a++) {
                                    if ($a == 0) {
                                        //2ème redoublement 7ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau7eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        //2ème redoublement 8ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau8eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    } elseif ($a == 2) {
                                        //2ème redoublement 8ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau9eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 3) {
                                //1er reoublement 4ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau4eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 3; $a++) {
                                    if ($a == 0) {
                                        //2ème redoublement 7ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau7eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        //2ème redoublement 8ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau8eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    } elseif ($a == 2) {
                                        //2ème redoublement 8ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau9eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 4) {
                                //1er reoublement 5ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau5eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 3; $a++) {
                                    if ($a == 0) {
                                        //2ème redoublement 7ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau7eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        //2ème redoublement 8ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau8eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    } elseif ($a == 2) {
                                        //2ème redoublement 8ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau9eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 4) {
                                //1er reoublement 6ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau6eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 3; $a++) {
                                    if ($a == 0) {
                                        //2ème redoublement 7ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau7eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        //2ème redoublement 8ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau8eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    } elseif ($a == 2) {
                                        //2ème redoublement 8ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau9eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            }
                        }
                    } elseif ($niveauDesignation === '9ème Année' && $scolaritee1 == 7 && $scolaritee2 == 5) {
                        for ($i = 0; $i < 6; $i++) {
                            //redoublement 3ème année
                            if ($i == 0) {
                                //1er redoublement 1ère année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau1ere);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 3; $a++) {
                                    if ($a == 0) {
                                        //2ème redoublement 7ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau7eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau9eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        //2ème redoublement 8ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau8eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau9eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 2) {
                                        //2ème redoublement 8ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau9eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau9eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 1) {
                                //1er reoublement 2ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau2eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 3; $a++) {
                                    if ($a == 0) {
                                        //2ème redoublement 7ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau7eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau9eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        //2ème redoublement 8ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau8eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau9eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 2) {
                                        //2ème redoublement 8ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau9eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau9eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 2) {
                                //1er reoublement 3ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau3eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 3; $a++) {
                                    if ($a == 0) {
                                        //2ème redoublement 7ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau7eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau9eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        //2ème redoublement 8ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau8eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau9eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 2) {
                                        //2ème redoublement 8ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau9eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau9eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 3) {
                                //1er reoublement 4ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau4eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 3; $a++) {
                                    if ($a == 0) {
                                        //2ème redoublement 7ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau7eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau9eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        //2ème redoublement 8ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau8eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau9eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 2) {
                                        //2ème redoublement 8ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau9eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau9eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 4) {
                                //1er reoublement 5ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau5eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 3; $a++) {
                                    if ($a == 0) {
                                        //2ème redoublement 7ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau7eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau9eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        //2ème redoublement 8ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau8eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau9eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 2) {
                                        //2ème redoublement 8ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau9eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau9eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 4) {
                                //1er reoublement 6ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau6eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 3; $a++) {
                                    if ($a == 0) {
                                        //2ème redoublement 7ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau7eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau9eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        //2ème redoublement 8ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau8eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau9eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 2) {
                                        //2ème redoublement 8ème année
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau9eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau9eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            }
                        }
                    } elseif ($niveauDesignation === '9ème Année' && $scolaritee1 == 8 && $scolaritee2 == 4) {
                        for ($i = 0; $i < 6; $i++) {
                            //redoublement 6ème année
                            if ($i == 0) {
                                //1er redoublement 1ère année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau1ere);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 5; $a++) {
                                    if ($a == 0) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau2eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau9eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau3eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau9eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 2) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau4eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau9eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 3) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau5eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau9eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 4) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau6eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau9eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 1) {
                                //1er reoublement 2ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau2eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 4; $a++) {
                                    if ($a == 0) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau3eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau9eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau4eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau9eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 2) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau5eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau9eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 3) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau6eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau9eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 2) {
                                //1er reoublement 3ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau3eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 3; $a++) {
                                    if ($a == 0) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau4eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau9eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau5eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau9eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 2) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau6eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau9eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 3) {
                                //1er reoublement 4ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau4eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 2; $a++) {
                                    if ($a == 0) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau5eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau9eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    } elseif ($a == 1) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau6eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau9eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 4) {
                                //1er reoublement 5ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau5eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 1; $a++) {
                                    if ($a == 0) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau6eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau9eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            } elseif ($i == 4) {
                                //1er reoublement 6ème année
                                $redoublement1 = new Redoublements1();
                                $redoublement1->setNiveau($niveau6eme);
                                $redoublement1->addScolarites1($scolarite1);
                                $redoublement1->addScolarites2($scolarite2);
                                for ($a = 0; $a < 1; $a++) {
                                    if ($a == 0) {
                                        $redoublement2 = new Redoublements2();
                                        $redoublement2->setNiveau($niveau6eme);
                                        $redoublement2->setRedoublement1($redoublement1);
                                        $redoublement2->addScolarites1($scolarite1);
                                        $redoublement2->addScolarites2($scolarite2);
                                        $redoublement3 = new Redoublements3();
                                        $redoublement3->setNiveau($niveau9eme);
                                        $redoublement3->setRedoublement2($redoublement2);
                                        $redoublement3->addScolarites1($scolarite1);
                                        $redoublement3->addScolarites2($scolarite2);
                                        $manager->persist($redoublement3);

                                        $manager->persist($redoublement2);
                                    }
                                }
                                $manager->persist($redoublement1);
                            }
                        }
                    }
                }
            }
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }

    private function configRedoublement1(ObjectManager $manager, $niveau, $redoublement1, $scolarite1, $scolarite2)
    {
        $redoublement1->setNiveau($niveau);
        $redoublement1->addScolarites1($scolarite1);
        $redoublement1->addScolarites2($scolarite2);
        $manager->persist($redoublement1);

    }
    private function configRedoublement2(ObjectManager $manager, $niveau, $redoublement2, $redoublement1, $scolarite1, $scolarite2)
    {
        $redoublement2->setNiveau($niveau);
        $redoublement2->setRedoublement1($redoublement1);
        $redoublement2->addScolarites1($scolarite1);
        $redoublement2->addScolarites2($scolarite2);
        $manager->persist($redoublement2);
    }

    public function getDependencies(): array
    {
        return [
            EtablissementsFixtures::class
        ];
    }
}
