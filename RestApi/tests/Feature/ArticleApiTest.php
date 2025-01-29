<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleApiTest extends TestCase
{
    use RefreshDatabase;

       public function it_can_fetch_articles()
       {
           $articles = Article::factory()->count(3)->create();

           $response = $this->getJson('/api/articles');

           $response->assertStatus(200)
                    ->assertJsonCount(3)
                    ->assertJson([
                        [
                            'id' => $articles[0]->id,
                            'title' => $articles[0]->title,
                            'heading' => $articles[0]->heading,
                            'content' => $articles[0]->content,
                            'image' => $articles[0]->image,
                            'user_id' => $articles[0]->user_id,
                        ],
                    ]);
       }

       public function it_can_create_an_article()
       {
           $this->withoutExceptionHandling();

           $data = [
               'title' => 'New Article',
               'content' => 'Content of the new article.',
           ];

           $response = $this->postJson('/api/articles', $data);

           $response->assertStatus(201)
                    ->assertJson([
                        'title' => 'New Article',
                        'content' => 'Content of the new article.',
                    ]);

           $this->assertDatabaseHas('articles', $data);
       }
}
