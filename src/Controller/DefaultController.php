<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Currency;
use App\Filter\StatisticFilter;
use App\Repository\StatisticRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class DefaultController extends AbstractController
{
    /**
     * @var StatisticRepository
     */
    private $statisticRepository;

    /**
     * @var DenormalizerInterface
     */
    private $denormalizer;

    /**
     * DefaultController constructor.
     *
     * @param StatisticRepository   $statisticRepository
     * @param DenormalizerInterface $denormalizer
     */
    public function __construct(StatisticRepository $statisticRepository, DenormalizerInterface $denormalizer)
    {
        $this->statisticRepository = $statisticRepository;
        $this->denormalizer = $denormalizer;
    }

    /**
     * @Route("/", name="default")
     */
    public function index()
    {
        $this->getDoctrine()->getRepository(Currency::class)->findOneBy(['code' => 'BTC']);

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/statistic", name="statistic", methods={"GET"})
     */
    public function statistic(Request $request)
    {
        try {
            /** @var StatisticFilter $filter */
            $filter = $this->denormalizer->denormalize($request->query->all(), StatisticFilter::class);
        } catch (ExceptionInterface $e) {
            throw new NotFoundHttpException();
        }

        return $this->json($this->statisticRepository->findAllByFilter($filter));
    }
}
