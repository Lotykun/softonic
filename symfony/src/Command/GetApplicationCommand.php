<?php

namespace App\Command;

use App\Entity\Application;
use App\Entity\Developer;
use App\Entity\Extra;
use App\Object\ApiErrorResponse;
use App\Object\ApplicationResponse;
use App\Service\Providers\Application\ApplicationProviderService;
use App\Service\Providers\Developer\DeveloperProviderService;
use App\Service\Providers\Extra\ExtraProviderService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class GetApplicationCommand extends Command
{
    protected static $defaultName = 'app:get-application';
    protected static $defaultDescription = 'Command to test the application as command Line';
    private $appProvider;
    private $developerProvider;
    private $extraProvider = null;

    protected function configure(): void
    {
        $this
            ->addArgument('id', InputArgument::REQUIRED, 'Application Id')
        ;
    }

    public function __construct(ApplicationProviderService $appProviderService, DeveloperProviderService $devProviderService, ExtraProviderService $extraProviderService)
    {
        $this->appProvider = $appProviderService;
        $this->developerProvider = $devProviderService;
        $this->extraProvider = $extraProviderService;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('id');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        try {
            /** @var Application $app */
            $app = $this->appProvider->getData($arg1);

            /** @var Developer $developer */
            $developer = $this->developerProvider->getData($app->getDeveloper()->getDeveloperId());

            $extra = null;
            if ($this->extraProvider->isEnabled()){
                /** @var Extra $extra */
                $extra = $this->extraProvider->getData($arg1);
            }
            $object = new ApplicationResponse($app, $developer, $extra);

        } catch (\Exception $e){
            $object = new ApiErrorResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($object, JsonEncoder::FORMAT, [JsonEncode::OPTIONS => JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT]);
        $io->text($jsonContent);

        $io->success('COMMAND COMPLETE');

        return Command::SUCCESS;
    }
}
