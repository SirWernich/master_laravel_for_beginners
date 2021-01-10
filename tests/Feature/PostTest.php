<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function testNoBlogPostsYet()
    {
        $response = $this->get('/posts');

        $response->assertSeeText('No posts yet');
    }

    public function testSeeOneBlogPostWhenThereIsOneWithNoComments()
    {
        // arrange
        $this->createDummyBlogPost();

        // act
        $response = $this->get('/posts');

        // assert
        $response->assertSeeText('New Title');
        $response->assertSeeText('No comments');

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New Title'
        ]);
    }

    public function testSeeOneBlogPostWithComments()
    {
        // arrange
        $post = $this->createDummyBlogPost();
        Comment::factory()->count(4)->create(['blog_post_id' => $post->id]);

        // act
        $response = $this->get('/posts');

        // assert
        $response->assertSeeText('4 comments');

    }

    public function testStoreValid()
    {
        $params = [
            'title' => 'Valid title',
            'content' => 'This is some valid content'
        ];

        $this
            ->actingAs($this->user())
            ->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'the blog post was created');
    }

    public function testInvalidContentFail()
    {
        $params = [
            'title' => 'x',
            'content' => 'x'
        ];

        $this
            ->actingAs($this->user())
            ->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('errors');

        $messages = session('errors')->getMessages();

        $this->assertEquals($messages['title'][0], 'The title must be at least 5 characters.');
        $this->assertEquals($messages['content'][0], 'The content must be at least 5 characters.');
    }

    public function testUpdateValid()
    {
        // arrange
        $post = $this->createDummyBlogPost();

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New Title',
            'content' => 'New post content'
        ]);

        $params = [
            'title' => 'New Title, but edited',
            'content' => 'New post content, but also edited'
        ];

        $this
            ->actingAs($this->user())
            ->put("/posts/{$post->id}", $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'blog post updated');

        $this->assertDatabaseMissing('blog_posts', $post->getAttributes());
        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New Title, but edited',
            'content' => 'New post content, but also edited'
        ]);
    }

    public function testDeletePost()
    {
        $post = $this->createDummyBlogPost();

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New Title',
            'content' => 'New post content'
        ]);

        $this
            ->actingAs($this->user())
            ->delete("/posts/{$post->id}")
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'blog post deleted');
        // $this->assertDatabaseMissing('blog_posts', $post->getAttributes());
        $this->assertSoftDeleted('blog_posts', $post->getAttributes());
    }

    private function createDummyBlogPost()
    {
        return BlogPost::factory()->newTitle()->create();
    }
}
