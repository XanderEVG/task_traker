<?php

namespace App\DataFixtures;

use App\Common\Auth\UserRoles;
use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $encoder;

    /**
     * AppFixtures constructor.
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $admin = new User();
        $admin->setUsername("admin");
        $admin->setPassword($this->encoder->encodePassword($admin, '1'));
        $admin->addRole(UserRoles::ROLE_ADMIN);
        $manager->persist($admin);
        $manager->flush();

        // По хорошему надо разбить этот метод на разные классы с передачей зависимостей(созданного юзера)
        $task = new Task();
        $task->setCaption("Задача 1: Верстка главной страницы");
        $task->setDescription("Познакомится с шаблонизатором twig, сделать верстку данной страницы");
        $task->setDate(new \DateTime());
        $task->setPerformer($admin);
        $manager->persist($task);
        $manager->flush();

        $task = new Task();
        $task->setCaption("Задача 2: Верстка страницы входа");
        $task->setDescription("Урл для логина: /api/login_check. Тип запроса: POST. Ожидаемые параметры - json вида {\"username\":\"admin\",\"password\":\"1\"} в теле запроса. Обязательно передавать Content-Type: application/json. Возвращаемые данные - json с токеном авторизации");
        $task->setDate(new \DateTime());
        $task->setPerformer($admin);
        $manager->persist($task);
        $manager->flush();

        $task = new Task();
        $task->setCaption("Задача 3: добавление задач");
        $task->setDescription("Добавить кнопку 'Создать задачу'. Урл: /api/tasks. Тип: post. При отправке запроса нужно передавать заголовок Authorization со значением 'Bearer полученный токен' и  Content-Type: application/json.  Слово Bearer - обязательно, затем пробел и сам токен. В теле запроса передать json с полями: caption, description, date, performer. Формат даты: YYYY-m-d. Значение performer = 1 (ид любого существующего в бд юзера)");
        $task->setDate(new \DateTime());
        $task->setPerformer($admin);
        $manager->persist($task);
        $manager->flush();

        $task = new Task();
        $task->setCaption("Доп задача: Обработка ошибок");
        $task->setDescription("Предусмотреть обработку различных ошибок(500ая, ошибка авторизации, etc).");
        $task->setDate(new \DateTime());
        $task->setPerformer($admin);
        $manager->persist($task);
        $manager->flush();
    }
}
