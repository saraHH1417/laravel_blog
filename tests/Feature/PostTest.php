<?php
namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Comments;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
use RefreshDatabase;
/**
* A basic feature test example.
*
* @return void
*/
    public function testNoBlogPostWhenNoPostIsInDatabase()
{
    $response= $this->get('/posts');
    $response->assertSeeText('No blog posts yet!');
}

public function testPublishedPost()
{

// Arrange
$post = $this->createDummyPost();

//Act
$response = $this->get('/posts');

//Assert
$response->assertSeeText('New Title');
$response->assertSeeText('No Comments Yet!');
$this->assertDatabaseHas('blog_posts', [
'title' => 'New Title'
]);

}

public function testShowOnePostWithComments()
{
$post = $this->createDummyPost();

Comments::factory()->count(3)->create(
['blog_post_id'=> $post->id]
);
$response = $this->get('/posts');
$response->assertSeeText('3 Comments');
}
public function testSuccessSession()
{
$params = [
'title' => 'New Title',
'content' => 'New Content'
];

$this->post('/posts' , $params)
->assertStatus(302)
->assertSessionHas('success');
$this->assertEquals('Blog post was created.', session('success'));
}

public function testStoreFail()
{
$params = [
'title' => 'x',
'content' => 'y'
];

$this->post('/posts' ,$params)
->assertStatus(302)
->assertSessionHas('errors');

$messages = session('errors')->getMessages();
$this->assertEquals('The title must be at least 3 characters.', $messages['title'][0]);
$this->assertEquals('The content must be at least 5 characters.', $messages['content'][0]);
}

public function testUpdateValid()
{
$post = $this->createDummyPost();

$this->assertDatabaseHas('blog_posts' , $post->toArray());

$params = [
'title' => 'new title',
'content' => 'my content is good'
];

$this->put("/posts/{$post->id}" , $params)
->assertStatus(302)
->assertSessionHas('success');

$this->assertEquals('Blog post has updated.' , session('success'));
$this->assertDatabaseMissing('blog_posts' , $post->toArray());
$this->assertDatabaseHas('blog_posts' , [
'title' => 'new title'
]);
}

public function testDelete()
{
$post = $this->createDummyPost();
$this->assertDatabaseHas('blog_posts' , $post->toArray());

$this->delete("/posts/{$post->id}")
->assertStatus(302)
->assertSessionHas('success');

$this->assertEquals('Post has deleted.', session('success'));
$this->assertDatabaseMissing('blog_posts' , $post->toArray());

}

private function createDummyPost()
{
    return BlogPost::factory()->newTitle()->create();
}
}
