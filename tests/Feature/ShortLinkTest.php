<?php

    namespace Tests\Feature;

    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Illuminate\Foundation\Testing\WithFaker;
    use Illuminate\Testing\Fluent\AssertableJson;
    use Tests\TestCase;

    class ShortLinkTest extends TestCase
    {
        /**
         * A basic feature test example.
         *
         * @return void
         */
        public function test_create_short_link_tinyurl(){
            $response = $this->post('/api/v1/shortlinks', [
                "url" => "https://example.com",
                "provider" => "tinyurl"
            ]);

            $response->assertStatus(200)
            ->assertJsonStructure([
                "url",
                "link"
            ]);
        }

        public function test_create_short_link_bitly(){
            $response = $this->post('/api/v1/shortlinks', [
                "url" => "https://example.com",
                "provider" => "bit.ly"
            ]);

            $response->assertStatus(200)
            ->assertJsonStructure([
                "url",
                "link"
            ]);
        }
    }
