<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints as Assert;

class ArticleType extends AbstractType
{
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'label' => $this->translator->trans('name', [], 'article')
            ])
            ->add('description', TextareaType::class, [
                'required' => true,
                'label' => $this->translator->trans('description', [], 'article'),
                'attr' => ['rows' => 5, 'cols' => 40]
            ])
            ->add('priceHT', MoneyType::class, [
                'required' => true,
                'label' => $this->translator->trans('price_HT', [], 'article'),
                'html5' => true,
                'scale' => 2,
                'attr' => [
                    'step' => '0.01', // Permet d'utiliser des centimes dans le champ
                ],
            ])
            ->add('image', FileType::class, [
                'required' => (!$builder->getData()->getId()) ? true : false,
                'label' => $this->translator->trans('image', [], 'article'),
                'constraints' => [
                    new Assert\Image([
                        'maxSize' => '2M',
                        'mimeTypes' => ['image/jpeg', 'image/png', 'image/gif'],
                        'mimeTypesMessage' => $this->translator->trans('article.image.format', [], 'validation'),
                    ]),
                ],
                'mapped' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
