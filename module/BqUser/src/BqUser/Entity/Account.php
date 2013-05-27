<?php
namespace BqUser\Entity;

class Account extends AbstractEntity implements AccountInterface
{
    protected $userEntityName;

    public function getUser() {
        $users = $this->getRelyonEntities(
            $this->getUserEntityName(), $this->userId);
        if($users && $users->count() > 0)
            return $users->current();
        return false;
    }

    public function setUser(UserInterface $user) {
        $this->userId = $user->id;
        $user->addRelyonEntity($this);
        return $this;
    }

    public function getEmail() { return $this->email; }
    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function getPassword() { return $this->password; }
    public function setPassword($password) {
        $this->password = md5($password);
        return $this;
    }

    public function getUserEntityName() { return $this->userEntityName; }
    public function setUserEntityName($entityName) {
        $this->userEntityName = $entityName;
        return $this;
    }
}
