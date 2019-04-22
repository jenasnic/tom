<?php

namespace App\Form\Slider;

use App\Entity\Book;
use App\Entity\Slider\Slider;
use App\Repository\BookRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SliderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('book', EntityType::class, [
                'class' => Book::class,
                'choice_label' => 'name',
                'multiple' => false,
                'empty_data' => ' - ',
                'query_builder' => function (BookRepository $bookRepository) {
                    return $bookRepository->createQueryBuilder('book')->addOrderBy('book.rank');
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Slider::class,
            'label_format' => 'form.slider.edit.label.%name%',
        ]);
    }
}
