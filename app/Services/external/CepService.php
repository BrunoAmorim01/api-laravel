<?Php

namespace App\Services\external;
use Http;
use Log;
class CepService
{
    public function getAddressFromCep($cep)
    {
        Log::info("Buscando CEP: {$cep}");
        $url = "https://viacep.com.br/ws/{$cep}/json";
        $response = Http::get($url);

        return $response->json();
    }
}
