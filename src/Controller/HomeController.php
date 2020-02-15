<?php

namespace App\Controller;

use App\Entity\Region;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(SerializerInterface $serializer, EntityManagerInterface $em)
    {
        $api = file_get_contents('https://geo.api.gouv.fr/regions');
        $api = $serializer->decode($api, 'json');


        foreach ($api as $value) {
            echo $value['nom']."<br>";
            $region = new Region();
            $region->setName($value['nom']);
            $em->persist($region);
            
        }
        $em->flush();
        //dump($api);
        //die();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
