<?php

namespace Arkon\Bundle\ApiBundle\Tests\Functional\Controller\User;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class ListUsersControllerTest
 * @package Arkon\Bundle\ApiBundle\Tests\Functional\Controller\User
 */
class ListUsersControllerTest extends UserControllerTestCase
{
    public function testListUsersWithoutParamsWillListAllUsers()
    {
        $this->client->request('GET', '/users');
        $response = $this->client->getResponse();

        $this->assertJsonResponse($response);
        $users = new ArrayCollection($this->getContainer()->get('serializer')->deserialize(
            $response->getContent(),
            'array<Arkon\Bundle\UserBundle\Entity\User>',
            'json'
        ));
        $this->assertCount(3, $users);
        $this->assertSame('nakard', $users->get(0)->getNickname());
        $this->assertSame('baddude', $users->get(1)->getNickname());
        $this->assertSame('abrakadabra', $users->get(2)->getNickname());
    }

    /**
     * @return array
     */
    public function listUsersProvider()
    {
        return [
            'nickname - bad' => [
                ['nickname' => 'bad'],
                [0 => 'baddude']
            ],
            'nickname - aka' => [
                ['nickname' => 'aka'],
                [0 => 'nakard', 1 => 'abrakadabra']
            ],
            'nickname - b + lastName - r' => [
                ['nickname' => 'b', 'lastName' => 'r'],
                [0 => 'baddude', 1 => 'abrakadabra']
            ],
            'full data of one user' => [
                ['nickname' => 'nakard', 'firstName' => 'Arkadiusz', 'lastName' => 'moskwa'],
                [0 => 'nakard']
            ]
        ];
    }

    /**
     * @dataProvider listUsersProvider
     * @param array $params
     * @param array $expectedData
     */
    public function testListUsersWithParamsWillListFilteredResultsBasedOnCriteria(array $params, array $expectedData)
    {
        $this->client->request('GET', '/users', $params);
        $response = $this->client->getResponse();

        $users = new ArrayCollection($this->getContainer()->get('serializer')->deserialize(
            $response->getContent(),
            'array<Arkon\Bundle\UserBundle\Entity\User>',
            'json'
        ));

        $this->assertJsonResponse($response);
        $this->assertCount(count($expectedData), $users);
        foreach ($expectedData as $key => $nickname) {
            $this->assertSame($nickname, $users->get($key)->getNickname());
        }
    }
}
