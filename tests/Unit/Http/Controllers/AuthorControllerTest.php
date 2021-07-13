<?php

namespace Tests\Unit\Http\Controllers;

use Tests\TestCase;
use Mockery;
use App\Http\Controllers\AuthorController;
use App\Models\Author;
use Illuminate\Database\Connection;
use Illuminate\Http\Request;
use App\Http\Requests\AuthorRequest;
use Symfony\Component\HttpFoundation\ParameterBag;
use Illuminate\Http\RedirectResponse;

class AuthorControllerTest extends TestCase
{
    /**
     * @var \Mockery\Mock|\Illuminate\Database\Connection
     */
    protected $db;

    /**
     * @var \Mockery\Mock|App\Models\Author
     */
    protected $authorMock;

    public function setUp() :void
    {
        $this->afterApplicationCreated(function () {
            $this->db = Mockery::mock(
                Connection::class.'[select,update,insert,delete]',
                [Mockery::mock(\PDO::class)]
            );

            $manager = $this->app['db'];
            $manager->setDefaultConnection('mock');

            $r = new \ReflectionClass($manager);
            $p = $r->getProperty('connections');
            $p->setAccessible(true);
            $list = $p->getValue($manager);
            $list['mock'] = $this->db;
            $p->setValue($manager, $list);

            $this->authorMock = Mockery::mock(Author::class . '[update, delete]');
        });

        parent::setUp();
    }

    public function testIndexReturnsView()
    {
        $controller = new AuthorController();

        $this->db->shouldReceive('select')->once()->withArgs([
            'select count(*) as aggregate from "authors" where "authors"."deleted_at" is null',
            [],
            Mockery::any(),
        ])->andReturn((object) ['aggregate' => 10]);

        $view = $controller->index();

        $this->assertEquals('admin.authors.index', $view->getName());
        $this->assertArrayHasKey('authors', $view->getData());
    }

    public function testItStoresNewAuthor()
    {
        $controller = new AuthorController();

        $data = [
            'author_name' => 'J.K. Rowling',
            'author_desc' => 'An author of Harry Potter series',
        ];

        $request = new AuthorRequest();
        $request->headers->set('content-type', 'application/json');
        $request->setJson(new ParameterBag($data));

        $this->db->getPdo()->shouldReceive('lastInsertId')->andReturn(254);
        $this->db->shouldReceive('insert')->once()
            ->withArgs([
                'insert into "authors" ("author_name", "author_desc", "updated_at", "created_at") values (?, ?, ?, ?)',
                Mockery::on(function ($arg) {
                    return is_array($arg);
                })
            ])
            ->andReturn(true);

        /** @var RedirectResponse $response */
        $response = $controller->store($request);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('authors.index'), $response->headers->get('Location'));
        $this->assertEquals(trans('message.add_success'), $response->getSession()->get('add_success'));
    }

    public function testCreateReturnsView()
    {
        $controller = new AuthorController();

        $view = $controller->create();

        $this->assertEquals('admin.authors.add', $view->getName());
    }

    public function testEditAuthor()
    {
        $authorInfo = [
            'author_id' => 1,
            'author_name' => 'J.K. Rowling',
            'author_desc' => 'An author of Harry Potter series',
        ];
        $author = new Author($authorInfo);

        $controller = new AuthorController();

        $view = $controller->edit($author);
        $this->assertEquals('admin.authors.edit', $view->getName());
    }

    public function testUpdateExistingAuthor()
    {
        $controller = new AuthorController();

        $data = [
            'author_id' => 1,
            'author_name' => 'J.K. Rowling',
            'author_desc' => 'An author of Harry Potter series',
        ];

        $author = $this->authorMock->forceFill(
            [
                'author_id' => 1,
                'author_name' => 'Authur Conan Doyle',
                'author_desc' => 'An author of Sherlock Holmes series',
            ]
        );
        $newAuthor = (new Author())->forceFill(
            [
                'author_id' => 1,
                'author_name' => $data['author_name'],
                'author_desc' => $data['author_desc'],
            ]
        );

        $request = new AuthorRequest();
        $request->headers->set('content-type', 'application/json');
        $request->setJson(new ParameterBag($data));

        $this->authorMock->shouldReceive('update')->once()->withArgs([
            Mockery::on(function ($arg) {
                return is_array($arg);
            })])->andReturn($newAuthor);

        $this->db->getPdo()->shouldReceive('lastInsertId')->andReturn($data['author_id']);

        $response = $controller->update($request, $author);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('authors.index'), $response->headers->get('Location'));
        $this->assertEquals(trans('message.update_success'), $response->getSession()->get('update_success'));
    }

    public function testDestroyExistingAuthor()
    {
        $controller = new AuthorController();

        $data = [
            'author_id' => 1,
            'author_name' => 'Authur Conan Doyle',
            'author_desc' => 'An author of Sherlock Holmes series',
        ];

        $author = $this->authorMock->forceFill($data);

        $this->authorMock->shouldReceive('delete')->once()->andReturn(true);

        $response = $controller->destroy($author);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('authors.index'), $response->headers->get('Location'));
        $this->assertEquals(trans('message.del_success'), $response->getSession()->get('del_success'));
    }
}
