<?php namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait ParseSsr {

    public function getInfoFromPage($url) {
        $apiURL = 'https://chrome.browserless.io/function?TOKEN=430e2beb-8581-4a27-9bea-22bb593371fe';
        $postInput = [
            "code" => "module.exports = async( {page:a, context:b } )=> {
                            const {url:c} = b;
                            await a.goto(c);
                            const d = await a.content();
                            while(await a.$('.loadmore')) {await a.click('.loadmore')}
                            const urls = await a.\$\$eval('.product-card', card => {
                                return card.map(el => {
                                    let name = el.querySelector('.product-card__title h3').textContent;
                                    let brand = el.querySelector('.product-card__manufacturere').textContent;
                                    let url = el.querySelector('.product-card__link').href;
                                    return {'name': name, 'brand': brand.trim(), 'url': url};
                                });
                            });
                            return { data: JSON.stringify(urls), type: \"application/json\" }
                            };",
            "context" => (object) array(
                "url" => $url
            )
        ];

        $headers = [
            'Content-Type' => 'application/json'
        ];

        $response = Http::withHeaders($headers)->post($apiURL, $postInput);
//        $statusCode = $response->status();
        $responseBody = json_decode($response->getBody(), true);

        if($responseBody) return json_decode($responseBody);
        else return [];
    }

}
