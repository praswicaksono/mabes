<?php


namespace Mabes\Commands;

use Mabes\Entity\Rebates;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;
class ImportRebateCommand extends BaseCommand
{
    /**
     * @var string
     */
    private $dir_data;

    /**
     * @var string
     */
    private $backup_dir;

    /**
     * @var string
     */
    protected $extensions;


    /**
     * @var string
     */
    protected  $file_name = null;

    /**
     * @var string
     */
    protected  $file_path = null;

    /**
     * @var array
     */
    protected  $data_parser = array();

    protected function configure()
    {
        $this->setName("import:rebate")
            ->setDescription("Import Rebate");

        $this->setDirData(APP_DIR."Data");
        $this->setBackupDir(APP_DIR."Backup/Statement");
        $this->setExtensions("htm");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->scanDir();
        if($this->getFileName() === null){
            $output->writeln("no htm file");
            return false;
        }

        $this->crawlerFile();
        if($this->deleteFilePath()){
            $this->insertDBFromArray();
        }

//        $output->writeln($this->getFileName());
    }

    private function scanDir(){

        $files = scandir($this->getDirData());

        foreach ($files as $filename) {
            $filePath = $this->getDirData().'/'.$filename;

            if(is_file($filePath)) {
                $ext = $this->getFileExtension($filePath);

                if ($ext == $this->getExtensions($filePath)) {
                    $this->setFilePath($filePath);
                    $this->setFileName($filename);
                }
            }
        }
    }

    private function getFileExtension($path){
        $path_parts = pathinfo($path);
        return $path_parts['extension'];
    }

    private function crawlerFile(){
        $html = file_get_contents($this->getFilePath());
        $crawler = new Crawler($html);

        $data[] = array();
        $data_result = array();
        $count_tr = $crawler
            ->filter('table > tr')
            ->count();

        for($i=1;$i< $count_tr;$i++){
            $data = $crawler
                ->filter('table > tr')
                ->eq($i)
                ->filter("td")
                ->each(function (Crawler $node, $i) {
                    return $node->text();
                });
                if(count($data) > 3){
                    if(preg_match("/agent/", $data[3])){

                        $explode_comment = explode("'",$data[3]);

                        $str_pos = strpos($data[3],"#")+1;
                        $ticket_referral = substr($data[3],$str_pos);
                        $data_result[] = array(
                            "ticket"=>$data[0],
                            "open_time"=>str_replace(".","-",$data[1]),
                            "login"=>$explode_comment[1],
                            "ticket_referral"=>$ticket_referral,
                            "profit"=>$data[4],
                        );
                    }
                }
        }

        $this->setDataParser($data_result);
    }

    private function insertDBFromArray(){
        foreach($this->getDataParser() as $data){
            $rebates = new Rebates();
            $rebates->setTicket($data['ticket']);
            $rebates->setOpenTime(new \DateTime($data['open_time']));
            $rebates->setLogin($data['login']);
            $rebates->setTicketReferral($data['ticket_referral']);
            $rebates->setProfit($data['profit']);

            $this->slim_app->em->persist($rebates);
            $this->slim_app->em->flush();
        }
    }

    private function deleteFilePath(){
        if (rename($this->getFilePath(),$this->getBackupDir()."/".$this->getFileName()))
            return true;
        return false;
    }

    /**
     * @return string
     */
    public function getDirData()
    {
        return $this->dir_data;
    }

    /**
     * @param string $dir_data
     */
    public function setDirData($dir_data)
    {
        $this->dir_data = $dir_data;
    }

    /**
     * @return string
     */
    public function getExtensions()
    {
        return $this->extensions;
    }

    /**
     * @param string $extensions
     */
    public function setExtensions($extensions)
    {
        $this->extensions = $extensions;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->file_name;
    }

    /**
     * @param string $file_name
     */
    public function setFileName($file_name)
    {
        $this->file_name = $file_name;
    }

    /**
     * @return string
     */
    public function getFilePath()
    {
        return $this->file_path;
    }

    /**
     * @param string $file_path
     */
    public function setFilePath($file_path)
    {
        $this->file_path = $file_path;
    }

    /**
     * @return array
     */
    public function getDataParser()
    {
        return $this->data_parser;
    }

    /**
     * @param array $data_parser
     */
    public function setDataParser($data_parser)
    {
        $this->data_parser = $data_parser;
    }

    /**
     * @return string
     */
    public function getBackupDir()
    {
        return $this->backup_dir;
    }

    /**
     * @param string $backup_dir
     */
    public function setBackupDir($backup_dir)
    {
        $this->backup_dir = $backup_dir;
    }

}

// EOF
