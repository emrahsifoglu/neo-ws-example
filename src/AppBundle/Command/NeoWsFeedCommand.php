<?php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class NeoWsFeedCommand extends ContainerAwareCommand
{

    protected function configure() {
        $this
            ->setName('neo:ws:feed')
            ->setDescription('Find Near Earth Objects in last 3 Days');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $data = [
            '=============================================',
            '           NEO Feed for last 3 days          ',
            '=============================================',
        ];
        $output->writeln($data);

        $style = new SymfonyStyle($input, $output);
        $progressBar = $style->createProgressBar(100);
        $progressBar->display();

        $container = $this->getContainer();

        $neoFacade = $container->get('facade.neo');
        $neoWs = $container->get('app.neo_ws');
        $contents = $neoWs->feedInLastDays(3);

        $progressBar->advance(10);

        foreach ($contents as $date => $objects) {
            foreach ($objects as $object) {
                $neo = $neoFacade->createFromContent($object);
                $neoFacade->save($neo, false);
            }
        }

        $neoFacade->removeAll();
        $neoFacade->getDocumentManager()->flush();

        $totalCount = $neoFacade->getTotalCount();
        $hazardousCount = $neoFacade->getHazardousCount();

        $fastest = $neoFacade->getFastest();
        $fastestHazardous = $neoFacade->getFastest(true);

        $slowest = $neoFacade->getSlowest();
        $slowestHazardous = $neoFacade->getSlowest(true);

        $rows = [
            'Fastest' => $fastest->getSpeed(),
            'Fastest hazardous' => $fastestHazardous->getSpeed(),
            'Slowest' => $slowest->getSpeed(),
            'Slowest Hazardous' => $slowestHazardous->getSpeed(),
        ];

        $footer = $totalCount
            ? sprintf('<comment>"%d" NEO(s) was successfully fetched.</comment>', $totalCount)
            : '<comment>Nothing fetched.</comment>';

        $table = new Table($output);
        $table->addRow(['Hazardous count',    sprintf(' <info>%s</info>', $hazardousCount)]);
        $table->addRows([new TableSeparator()]);
        $table->addRow(['']);
        $table->addRow(['Speed', 'Kilometers per hour']);

        $step = (90 / count($rows));
        $index = 1;
        foreach ($rows as $row => $data) {
            $table->addRow([
                $row,
                sprintf(' <info>%s</info>', $data)
            ]);
            $progressBar->advance($step);

            $index++;
        }

        $progressBar->finish();
        $output->writeln('');

        $table->addRows([new TableSeparator()]);
        $table->addRow([new TableCell($footer, ['colspan' => 2,])]);
        $table->render();

    }
}
