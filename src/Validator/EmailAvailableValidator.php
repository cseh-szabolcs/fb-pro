<?php

namespace App\Validator;

use App\Contracts\EmailAwareInterface;
use App\Repository\UserRepository;
use App\Validator\Constraint\EmailAvailable;
use Doctrine\ORM\NoResultException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class EmailAvailableValidator extends ConstraintValidator
{
    public function __construct(
        private readonly UserRepository $userRepository,
    ) {}

    public function validate(mixed $value, Constraint $constraint): void
    {
        /* @var EmailAvailable $constraint */

        if (null === $value || '' === $value) {
            return;
        }

        assert(is_string($value) || $value instanceof EmailAwareInterface);

        try {
            $this->userRepository->findOneByEmail($value);

            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation()
            ;
        } catch (NoResultException) {}
    }

    private function assertValue()
    {

    }
}
