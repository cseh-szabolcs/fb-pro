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
            $email = $this->getEmail($value);
            $this->userRepository->findOneByEmail($email);

            $violation = $this->context
                ->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $email)
            ;

            if ($value instanceof EmailAwareInterface) {
                $violation->atPath($constraint->propertyPath);
            }

            $violation->addViolation();
        } catch (NoResultException) {}
    }

    private function getEmail(string|EmailAwareInterface $value): string
    {
        return $value instanceof EmailAwareInterface ? $value->getEmail() : $value;
    }
}
