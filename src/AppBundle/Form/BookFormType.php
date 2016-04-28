<?php
/**
 * Created by PhpStorm.
 * User: letunovskiymn
 * Date: 27.04.16
 * Time: 17:30
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class BookFormType extends AbstractType
{
    private $isEdit=true;

    /**
     * @param $isEdit
     */
    public function __construct($isEdit=true)
    {
        $this->isEdit=$isEdit;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'required' => true,
                'label' => 'book.name',
            ))
            ->add('author', 'text', array(
                'required' => true,
                'label' => 'book.author',
            ))
            ->add('isDownloaded', 'checkbox', array(
                'required' => false,
                'label' => 'book.is_downloaded',
            ))
            ->add('cover', 'file', array(
                'required' => false,
                'data_class'=>null,
                'label' => 'book.cover',
                'constraints' => array(
                    new Image(),
                ),
            ))
            ->add('fileBook', 'file', array(
                'required' => false,
                'data_class'=>null,
                'label' => 'book.file'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Book',
            'intention' => 'book',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'book';
    }
}
