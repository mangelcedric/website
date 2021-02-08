<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            EmailField::new('email', 'E-mail'),
            TextField::new('password')->onlyOnForms()->setFormType(PasswordType::class),
            ChoiceField::new('roles')
                 ->setChoices([
                    'Veuillez choisir' => 'ROLE_USER',
                    'Admin' => 'ROLE_ADMIN',
                    'Utilisateur' => 'ROLE_USER',
                     ])
                     ->allowMultipleChoices(),
            DateField::new('createdAt')->onlyOnIndex(),
        ];
    }

    /**
     * @param EntityManagerInterface $entityManager
     * @param User $entityInstance
     */
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityManager->getRepository(User::class)->findOneBy([
            'email' => $entityInstance->getEmail(),
        ])) {
            $this->container->get('session')->getFlashBag()->add('error', 'Email exists');
        } else {
            $entityManager->persist($entityInstance);
            $entityManager->flush();
        }
    }
    
}
