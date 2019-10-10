<?php 

namespace App\Controller;

use App\Entity\Aloitelaatikko;
use App\Form\AloiteFormType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AloitelaatikkoController extends AbstractController {

    /**
     * @Route("/aloite", name="aloite_lista")
     */

     public function index() {  
        // Haetaan kaikki aloitteet tietokannasta
        $aloitteet = $this->getDoctrine()->getRepository(Aloitelaatikko::class)->findAll();

        // Pyydetään näkymää näyttämään tiedot
         return $this->render('aloitelaatikko/index.html.twig', ['aloitteet' => $aloitteet]);
     }

     /**
      * @Route("aloite/uusiAloite", name="aloite_uusi")
      */
     public function uusi(Request $request){
         // Luodaan uusi olio
         $aloite = new Aloitelaatikko();

         //Luodaan lomake
         $form = $this->createForm(
             AloiteFormType::class,
             $aloite, [
             'action' => $this->generateUrl('aloite_uusi'),
             'attr' => ['class' => 'form-signin']
         ]);

         // Käsitellään lomakkeelta tulleet tiedot ja tallennetaan  tietokantaan
         $form->handleRequest($request);
         if($form->isSubmitted()){
             // Tallennetaal lomaketiedot muuttujaan
             $aloite = $form->getData();

             //Tallennetaan tietokantaan
             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($aloite);
             $entityManager->flush();

             //Kutsutaan pääsivua
             return $this->redirectToRoute('aloite_lista');
         }

         // Pyydetään näkymää näyttämään lomaketta
         return $this->render('aloitelaatikko/uusiAloite.html.twig', [
             'form1' => $form->createView()
         ]);
     }
    

     /**
      * @Route("aloitelaatikko/naytaAloite/{id}", name="aloite_nayta")
      */
     public function nayta($id){
         $aloite = $this->getDoctrine()->getRepository(Aloitelaatikko::class)->find($id);

        return $this->render('aloitelaatikko/naytaAloite.html.twig', [
            'aloite' => $aloite
        ]);
     }


     /**
      * @Route("aloitelaatikko/poistaAloite/{id}", name="aloite_poista")
      */
      public function poista(Request $request, $id){
          $aloite = $this->getDoctrine()->getRepository(Aloitelaatikko::class)->find($id);

          // Poistetaan aloite kannasta 
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->remove($aloite);
          $entityManager->flush();

          // 
          return $this->redirectToRoute('aloite_lista');
      }


      /**
       * @Route("aloitelaatikko/muokkaaAloite/{id}", name="aloite_muokkaa")
       */
      public function muokkaa(Request $request, $id){
          $aloite = $this->getDoctrine()->getRepository(Aloitelaatikko::class)->find($id);

          // Luodaan lomake
          $form = $this->createForm(
              AloiteFormType::class,
              $aloite, [
                  'attr' => ['class' => 'form-signin']
              ]
              );
            // Käsitellään lomakkeelta tulleet tiedot ja tallennetaan tietokantaan 
            $form->handleRequest($request);
            if($form->isSubmitted()){
                $aloite = $form->getData();

            // Tallennetaan tietokantaan 
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            // Kutsutaan pääsivua 
            return $this->redirectToRoute('aloite_lista');
            }

          return $this->render('aloitelaatikko/muokkaaAloite.html.twig', [
              'form1' => $form->createView()
          ]);
      }

    }

?>