<?php

namespace App\Form;
use App\Entity\Classroom;
use App\Entity\Student;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType; 

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nce')
            ->add('username')
            ->add('moyenne')
           // ->add('Classroom') // ajout 1ere methode
            ->add('Classroom',EntityType::class,array(
                   'class'=>Classroom::class,'choice_label'=>'name' )) // ajout 2emme methode
            ->add("submit",SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
