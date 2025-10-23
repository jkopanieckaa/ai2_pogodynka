<?php
namespace App\Controller;

use App\Repository\LocationRepository;
use App\Repository\MeasurementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class WeatherController extends AbstractController
{
    #[Route('/weather/{city}', name: 'app_weather_city', requirements: ['city' => '[\p{L}\s\-]+'])]
    #[Route(
        '/weather/{city}/{country}',
        name: 'app_weather_city_country',
        requirements: ['city' => '[\p{L}\s\-]+', 'country' => '[A-Z]{2}']
    )]

//    public function city(
//        string $city,
//        ?string $country,
//        LocationRepository $locations,
//        MeasurementRepository $measurementsRepo
//    ): Response {
//        $criteria = ['city' => $city];
//        if ($country) {
//            $criteria['country'] = strtoupper($country);
//        }
//
//        $location = $locations->findOneBy($criteria);
//        if (!$location) {
//            throw $this->createNotFoundException('Location not found.');
//        }
//
//        $measurements = $measurementsRepo->findByLocation($location);
//
//        return $this->render('weather/city.html.twig', [
//            'location'     => $location,
//            'measurements' => $measurements,
//        ]);
//    }
//
    #[Route('/weather/{id}', name: 'app_weather', requirements: ['id' => '\d+'])]
    public function city(Location $location, MeasurementRepository $repo): Response
    {
        // BEZ filtrowania na przyszłość – pokaż wszystko dla tej lokalizacji
        $measurements = $repo->findBy(['location' => $location], ['measuredAt' => 'DESC']);

        return $this->render('weather/city.html.twig', [
            'location' => $location,
            'measurements' => $measurements,
        ]);
    }

}
