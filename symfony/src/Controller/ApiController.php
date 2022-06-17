<?php

namespace App\Controller;

use App\Entity\Application;
use App\Entity\Developer;
use App\Entity\Extra;
use App\Object\ApiErrorResponse;
use App\Object\ApplicationResponse;
use App\Service\Providers\Application\ApplicationProviderService;
use App\Service\Providers\Developer\DeveloperProviderService;
use App\Service\Providers\Extra\ExtraProviderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Application Controller
 * @Route("/api", name="api_")
 */
class ApiController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ApiController.php',
        ]);
    }

    /**
     * @Route("/application/{id}", name="get_application", methods={"GET"})
     * @param $id
     * @param ApplicationProviderService $appProvider
     * @param DeveloperProviderService $developerProvider
     * @param ExtraProviderService $extraProvider
     * @return Response
     */
    public function getApplicationAction($id, ApplicationProviderService $appProvider, DeveloperProviderService $developerProvider, ExtraProviderService $extraProvider) : Response
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        try {
            /** @var Application $app */
            $app = $appProvider->getData($id);

            /** @var Developer $developer */
            $developer = $developerProvider->getData($app->getDeveloper()->getDeveloperId());

            $extra = null;
            if ($extraProvider->isEnabled()){
                /** @var Extra $extra */
                $extra = $extraProvider->getData($id);
            }
            $object = new ApplicationResponse($app, $developer, $extra);

        } catch (NotFoundHttpException $e) {
            $object = new ApiErrorResponse(JsonResponse::HTTP_NOT_FOUND, $e->getMessage());
            $content = $serializer->serialize($object, JsonEncoder::FORMAT, [JsonEncode::OPTIONS => JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT]);
            $response = new Response($content, JsonResponse::HTTP_NOT_FOUND);
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        } catch (\Exception $e){
            $object = new ApiErrorResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
            $content = $serializer->serialize($object, JsonEncoder::FORMAT, [JsonEncode::OPTIONS => JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT]);
            $response = new Response($content, JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }

        $content = $serializer->serialize($object, JsonEncoder::FORMAT, [JsonEncode::OPTIONS => JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT]);
        $response = new Response($content, JsonResponse::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
