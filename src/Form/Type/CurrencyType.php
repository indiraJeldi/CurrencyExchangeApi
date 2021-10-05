<?php
namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class CurrencyType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $codeChoices = $options['choices'];
        //var_dump($codeChoices);
        $builder
            ->add('srcCurrency', ChoiceType::class, [
                'placeholder' => 'Choose an option',
                'required' => true,
                'choices'  => [
                    'EUR' => 'EUR',
                ],
            ])
            ->add('destCurrency', ChoiceType::class, [
                'placeholder' => 'Choose an option','required' => true,
                'choices'  => [
                    'USD' => 'USD',
                    'JPY' => 'JPY',
                    'INR' => 'INR',
                    'BGN' => 'BGN'
                ],
            ])
            ->add('amount', TextType::class,  ['required' => true,'constraints' => new NotBlank(), 'attr' => array('min' => 10, 'max' => 1000000)])
            ->add('total', HiddenType::class)
            ->add('conversionRate', HiddenType::class)
            ->add('save', SubmitType::class, ['label' => 'Convert']);
    }

    /**
    * {@inheritdoc}
    */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
                'choices' => array(
                    'EUR'=>'EUR'
                ),
            ));
    }
}
