<?php

namespace App\Form;

use App\Entity\Aloitelaatikko;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class AloiteFormType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add('Aihe', TextType::class, ['label' => 'Aihe'])
            ->add('Nimi', TextType::class, ['label' => 'Nimi'])
            ->add('Kuvaus', TextareaType::class, ['label' => 'Kuvaus'])
            ->add('Kirjauspaiva', DateType::class, ['label' => 'Kirjauspäivä'])
            ->add('Email', TextType::class, ['label' => 'Email'])
            ->add('Save', SubmitType::class, [
                'label' => 'Tallenna',
                'attr' => ['class' => 'btn btn-info']]);

        }

    public function configureOptions(OptionsResolver $resolver){
        $resolver->setDefaults([
            'data-class' => Aloitelaatikko::class
        ]);
        
    }
        
    }

