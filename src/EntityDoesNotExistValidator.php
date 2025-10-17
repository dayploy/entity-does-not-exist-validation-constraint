<?php

declare(strict_types=1);

namespace Dayploy\Validator\Constraint;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class EntityDoesNotExistValidator extends ConstraintValidator
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {
    }

    public function validate(
        $value,
        Constraint $constraint,
    ): void {
        if (!$constraint instanceof EntityDoesNotExist) {
            throw new \LogicException(\sprintf('You can only pass %s constraint to this validator.', EntityDoesNotExist::class));
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (empty($constraint->entity)) {
            throw new \LogicException(\sprintf('Must set "entity" on "%s" validator', EntityDoesNotExist::class));
        }

        $data = $this->em->getRepository($constraint->entity)->findOneBy([
            $constraint->property => $value,
        ]);

        if (null === $data) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('%entity%', $constraint->entity)
            ->setParameter('%property%', $constraint->property)
            ->setParameter('%value%', (string) $value)
            ->addViolation();
    }
}
