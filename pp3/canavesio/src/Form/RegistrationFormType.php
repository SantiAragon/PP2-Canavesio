<?php
 
namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Type;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('username', TextType::class, [
                'label' => 'Nombre de usuario',
                'attr' => [
                    'placeholder' => 'Nombre de usuario',
                    'minlength' => '3',
                    'maxlength' => '10'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'El nombre de usuario no puede estar vacío'
                    ]),
                    new Type([
                        'type' => 'string',
                        'message' => 'El nombre de usuario debe ser texto'
                    ]),
                    new Length([
                        'min' => 3,
                        'max' => 10,
                        'minMessage' => 'El nombre de usuario debe tener al menos {{ limit }} caracteres',
                        'maxMessage' => 'El nombre de usuario no puede tener más de {{ limit }} caracteres'
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9]+$/',
                        'message' => 'El nombre de usuario solo puede contener letras y números'
                    ])
                ]
            ])
            ->add('phone', TelType::class, [
                'label' => 'Teléfono',
                'required' => false,
                'attr' => ['placeholder' => 'Teléfono (opcional)'],
            ])
            ->add('securityQuestion', ChoiceType::class, [
                'label' => 'Pregunta clave',
                'choices' => [
                    '¿Cuál es su comida favorita?' => 'comida_favorita',
                    '¿Cuál es el nombre de su mascota?' => 'nombre_mascota',
                    '¿Cuál fue su primer trabajo?' => 'primer_trabajo',
                ],
                'placeholder' => 'Seleccione una pregunta',
            ])
            ->add('securityAnswer', TextType::class, [
                'label' => 'Respuesta a la pregunta clave',
                'required' => true,
                'attr' => ['placeholder' => 'Escriba su respuesta'],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Debe aceptar nuestros términos.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor, introduzca una contraseña',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Su contraseña debe tener al menos {{ limit }} caracteres',
                        
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]), 
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
