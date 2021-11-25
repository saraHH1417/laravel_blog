<?php
namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Comments;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
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
    $user = $this->user();

    Comments::factory()->count(3)->create(
    ['commentable_id'=> $post->id,
     'commentable_type' => 'App\Models\BlogPost',
     'user_id' => $user->id
    ]);
    $response = $this->get('/posts');
    $response->assertSeeText('3 Comments');
}
public function testSuccessSession()
{
    $params = [
    'title' => 'New Title',
    'content' => 'New Content'
    ];

    $this->actingAs($this->user())
    ->post('/posts' , $params)
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

    $this->actingAs($this->user())
    ->post('/posts' ,$params)
    ->assertStatus(302)
    ->assertSessionHas('errors');

    $messages = session('errors')->getMessages();
    $this->assertEquals('The title must be at least 3 characters.', $messages['title'][0]);
    $this->assertEquals('The content must be at least 5 characters.', $messages['content'][0]);
}

    public function testUpdateValid()
    {
        $user = $this->user();
        $post = $this->createDummyPost($user->id);

        $this->assertDatabaseHas('blog_posts' , [
            'id' => $post->id,
            'title' => $post->title,
            'content' => $post->content,
            'created_at' => $post->created_at,
            'updated_at' => $post->updated_at,
            'user_id' => $post->user_id
        ]);

        $params = [
            'title' => 'new title',
            'content' => 'my content is good'
        ];

        $this->actingAs($user)
            ->put("/posts/{$post->id}" , $params)
            ->assertStatus(302)
            ->assertSessionHas('success');

        $this->assertEquals('Blog post has updated.' , session('success'));
        $this->assertDatabaseMissing('blog_posts' , $post->toArray());
        $this->assertDatabaseHas('blog_posts' , [
        'title' => 'new title'
        ]);
    }

    public function testUpdateValidWhenUserIsAmin()
    {
        $post = $this->createDummyPost();

        $this->assertDatabaseHas('blog_posts' , [
            'id' => $post->id,
            'title' => $post->title,
            'content' => $post->content,
            'created_at' => $post->created_at,
            'updated_at' => $post->updated_at,
            'user_id' => $post->user_id
        ]);

        $params = [
            'title' => 'new title',
            'content' => 'my content is good'
        ];

        $this->actingAs($this->adminUser())
            ->put("/posts/{$post->id}" , $params)
            ->assertStatus(302)
            ->assertSessionHas('success');

        $this->assertEquals('Blog post has updated.' , session('success'));
        $this->assertDatabaseMissing('blog_posts' , $post->toArray());
        $this->assertDatabaseHas('blog_posts' , [
            'title' => 'new title'
        ]);
    }

    public function testUpdateWhenUserIsNotAuthorized()
    {
        $post = $this->createDummyPost();

        $this->assertDatabaseHas('blog_posts' , [
            'id' => $post->id,
            'title' => $post->title,
            'content' => $post->content,
            'created_at' => $post->created_at,
            'updated_at' => $post->updated_at,
            'user_id' => $post->user_id
        ]);

        $params = [
            'title' => 'new title',
            'content' => 'my content is good'
        ];

        $this->actingAs($this->user())
            ->put("/posts/{$post->id}" , $params)
            ->assertStatus(403);

    }

public function testDelete()
{
    $user = $this->user();
    $post = $this->createDummyPost($user->id);
    $this->assertDatabaseHas('blog_posts' , [
        'id' => $post->id,
        'title' => $post->title,
        'content' => $post->content,
        'created_at' => $post->created_at,
        'updated_at' => $post->updated_at,
        'user_id' => $post->user_id
        ]);


        $this->actingAs($user)
            ->delete("/posts/{$post->id}")
            ->assertStatus(302)
            ->assertSessionHas('success');

    $this->assertEquals('Post has deleted', session('success'));
//    $this->assertDatabaseMissing('blog_posts' , $post->toArray());
    $this->assertSoftDeleted('blog_posts' , [
        'id' => $post->id,
        'title' => $post->title,
        'content' => $post->content,
        'created_at' => $post->created_at,
        'updated_at' => $post->updated_at,
        'user_id' => $post->user_id
    ]);

}

    public function testDeleteWhenUserIsAdmin()
    {
        $post = $this->createDummyPost();
        $this->assertDatabaseHas('blog_posts' , [
            'id' => $post->id,
            'title' => $post->title,
            'content' => $post->content,
            'created_at' => $post->created_at,
            'updated_at' => $post->updated_at,
            'user_id' => $post->user_id
        ]);

        $this->actingAs($this->adminUser())
            ->delete("/posts/{$post->id}")
            ->assertStatus(302)
            ->assertSessionHas('success');

        $this->assertEquals('Post has deleted', session('success'));
//    $this->assertDatabaseMissing('blog_posts' , $post->toArray());
        $this->assertSoftDeleted('blog_posts' , [
            'id' => $post->id,
            'title' => $post->title,
            'content' => $post->content,
            'created_at' => $post->created_at,
            'updated_at' => $post->updated_at,
            'user_id' => $post->user_id
        ]);

    }


    public function testDeleteWhenUserIsNotAuthorized()
    {
        $post = $this->createDummyPost();
        $this->assertDatabaseHas('blog_posts' , [
            'id' => $post->id,
            'title' => $post->title,
            'content' => $post->content,
            'created_at' => $post->created_at,
            'updated_at' => $post->updated_at,
            'user_id' => $post->user_id
        ]);

        $this->actingAs($this->user())
            ->delete("/posts/{$post->id}")
            ->assertStatus(403);

    }

    private function createDummyPost($userId = null): BlogPost
    {
        return BlogPost::factory()->newTitle()->create([
            'user_id' => $userId ?? $this->user()->id
        ]);
    }
}
