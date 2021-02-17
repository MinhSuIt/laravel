<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Core\Locale;

class LocaleApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_locale()
    {
        $locale = factory(Locale::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/core/locales', $locale
        );

        $this->assertApiResponse($locale);
    }

    /**
     * @test
     */
    public function test_read_locale()
    {
        $locale = factory(Locale::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/core/locales/'.$locale->id
        );

        $this->assertApiResponse($locale->toArray());
    }

    /**
     * @test
     */
    public function test_update_locale()
    {
        $locale = factory(Locale::class)->create();
        $editedLocale = factory(Locale::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/core/locales/'.$locale->id,
            $editedLocale
        );

        $this->assertApiResponse($editedLocale);
    }

    /**
     * @test
     */
    public function test_delete_locale()
    {
        $locale = factory(Locale::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/core/locales/'.$locale->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/core/locales/'.$locale->id
        );

        $this->response->assertStatus(404);
    }
}
