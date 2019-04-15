<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Video;
use App\Repository\BookRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class VideoType extends AbstractType
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
            ->add('videoFile', VichFileType::class, [
                'required' => false,
                'allow_delete' => true,
                'download_link' => true,
                'translation_domain' => 'messages',
                'download_label' => 'global.download',
                'delete_label' => 'global.delete',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Video::class,
            'label_format' => 'form.video.edit.label.%name%',
        ]);
    }
}
