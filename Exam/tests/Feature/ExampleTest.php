<?php

namespace Tests\Feature;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Response;
use Tests\TestCase;

class Test5 extends TestCase
{
    use WithoutMiddleware, RefreshDatabase;

    protected $modelFields = [
        "text",
        "short_text",
        "author_name"
    ];
    protected $modelClass = Article::class;
    protected $modelPluralName = "articles";
    protected $modelSingleName = "article";


    /* Checks json pagination */
    public function testIndex()
    {

        factory($this->modelClass, 50)->create();
        $per_page = rand(5, 15);
        $routeName = $this->modelPluralName . ".index";
        $response = $this->getJson(route($routeName, ['per_page' => $per_page]));
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure(["meta", "links", "data" => [$this->modelFields]]);
        $responseContent = $response->json();
        $this->assertCount($per_page, $responseContent["data"]);
        $this->assertEquals(50, $responseContent["meta"]["total"]);
    }

    /* Checks model creating */
    public function testCreate()
    {
        $routeName = $this->modelPluralName . ".create";
        $response = $this->get(route($routeName));
        $response->assertViewIs($routeName);
        $response->assertSee($this->modelPluralName . " form");
    }

    /* Checks model saving */
    public function testStoreOk()
    {
        $data = factory($this->modelClass)->make()->toArray();
        $routeName = $this->modelPluralName . ".store";
        $redirectRouteName = $this->modelPluralName . ".show";
        $response = $this->post(route($routeName), $data);
        $response->assertRedirect(route($redirectRouteName, [$this->modelSingleName => 1]));
    }

    /* Checks saving validation */
    public function testStoreError()
    {
        $routeName = $this->modelPluralName . ".store";
        $response = $this->post(route($routeName), []);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors($this->modelFields);
    }

   public function testShow()
   {
       $model = factory($this->modelClass)->create();
       $routeName = $this->modelPluralName . ".show";
       $response = $this->getJson(route($routeName, [$this->modelSingleName => $model->id]));
       $response->assertStatus(Response::HTTP_OK);
       $response->assertJsonStructure([ 'data' => $this->modelFields]);
   }


   public function testShowError()
   {
       $routeName = $this->modelPluralName . ".show";
       $response = $this->getJson(route($routeName, [$this->modelSingleName => 1]));
       $response->assertStatus(Response::HTTP_NOT_FOUND);
       $response->assertJson(['message' => "Not found"]);
   }


}
