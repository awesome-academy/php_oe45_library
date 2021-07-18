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
use App\Repositories\RepositoryInterface\AuthorRepositoryInterface;

class AuthorControllerTest extends TestCase
{
    /**
     * @var \Mockery\Mock|\Illuminate\Database\Connection
     */
    protected $db;
    protected $authorRepositoryMock;

    /**
     * @var \Mockery\Mock|App\Models\Author
     */

    public function setUp() :void
    {
        $this->afterApplicationCreated(function () {
            $this->authorRepositoryMock = Mockery::mock(AuthorRepositoryInterface::class);
        });

        parent::setUp();
    }

    public function testIndexReturnsView()
    {
        $this->authorRepositoryMock->shouldReceive('getLatest')->once();
        $controller = new AuthorController($this->authorRepositoryMock);
        $request = new Request();
        $view = $controller->index($request);

        $this->assertEquals('admin.authors.index', $view->getName());
        $this->assertArrayHasKey('authors', $view->getData());
    }

    public function testItStoresNewAuthor()
    {
        $this->authorRepositoryMock->shouldReceive('create')->once();
        $controller = new AuthorController($this->authorRepositoryMock);
        $data = [
            'author_name' => 'J.K. Rowling',
            'author_desc' => 'An author of Harry Potter series',
        ];
        $request = new AuthorRequest();
        $request->headers->set('content-type', 'application/json');
        $request->setJson(new ParameterBag($data));
        $response = $controller->store($request);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('authors.index'), $response->headers->get('Location'));
        $this->assertEquals(trans('message.add_success'), $response->getSession()->get('add_success'));
    }

    public function testCreateReturnsView()
    {
        $controller = new AuthorController($this->authorRepositoryMock);
        $view = $controller->create();

        $this->assertEquals('admin.authors.add', $view->getName());
    }

    public function testEditAuthor()
    {
        $this->authorRepositoryMock->shouldReceive('find')->once()->andReturnSelf();
        $controller = new AuthorController($this->authorRepositoryMock);

        $authorInfo = [
            'author_id' => 1,
            'author_name' => 'J.K. Rowling',
            'author_desc' => 'An author of Harry Potter series',
        ];
        $author = new Author($authorInfo);

        $view = $controller->edit($author);
        $this->assertEquals('admin.authors.edit', $view->getName());
    }

    public function testUpdateAuthor()
    {
        $this->authorRepositoryMock->shouldReceive('update')->once()->andReturnSelf();
        $controller = new AuthorController($this->authorRepositoryMock);

        $author = new Author([
            'author_id' => 1,
            'author_name' => 'Authur Conan Doyle',
            'author_desc' => 'An author of Sherlock Holmes series',
        ]);
        $request = new AuthorRequest();
        $response = $controller->update($request, $author);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('authors.index'), $response->headers->get('Location'));
        $this->assertEquals(trans('message.update_success'), $response->getSession()->get('update_success'));
    }

    public function testDestroyAuthor()
    {
        $this->authorRepositoryMock->shouldReceive('delete')->once()->andReturnSelf();
        $controller = new AuthorController($this->authorRepositoryMock);

        $author = new Author([
            'author_id' => 1,
            'author_name' => 'Authur Conan Doyle',
            'author_desc' => 'An author of Sherlock Holmes series',
        ]);

        $response = $controller->destroy($author->author_id);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('authors.index'), $response->headers->get('Location'));
        $this->assertEquals(trans('message.del_success'), $response->getSession()->get('del_success'));
    }
}
