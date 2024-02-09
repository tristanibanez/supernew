<?php

namespace App\Controller;

use App\Entity\Message;
use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class MessageController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(MessageRepository $messageRepository, EntityManagerInterface $entityManager, Request $request): Response
    {
        // creates a message object
        $message = new Message();

        $form = $this->createFormBuilder($message)
            ->add('name', TextType::class)
            ->add('message', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Save message'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $message_yo = $form->getData();


            // tell Doctrine you want to (eventually) save the Message (no queries yet)
            $entityManager->persist($message_yo);
            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();            
            return $this->redirectToRoute('newform');
        }
        return $this->render('message/index.html.twig', [
            'controller_name' => 'MessageController',
            'messages' => $messageRepository->findAll(),
            'form' => $form,
        ]);
    }


    #[Route('/new', name: 'newform')]
    public function new(EntityManagerInterface $entityManager, Request $request): Response
    {
        // creates a message object
        $message = new Message();

        $form = $this->createFormBuilder($message)
            ->add('name', TextType::class)
            ->add('message', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Save message'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $message_yo = $form->getData();


            // tell Doctrine you want to (eventually) save the Message (no queries yet)
            $entityManager->persist($message_yo);
            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();            
            return $this->redirectToRoute('newform');
        }
        return $this->render('message/new.html.twig', [
            'form' => $form,
        ]);
    }
}
