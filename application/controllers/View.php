<?php

defined('BASEPATH') or exit('No direct script access allowed');

class View extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('set_stat/stat_unit_model', "StatUnit");
        $this->load->model('set_stat/stat_site_model', "StatSite");
        $this->load->model('set_stat/stat_webmaster_model', "StatWebmaster");
        $this->load->model('set_stat/stat_camp_model', "StatCamp");
        $this->load->model('set_stat/stat_advertiser_model', "StatAdvertiser");
        $this->load->model('set_stat/stat_ad_model', "StatAd");
        $this->load->model('set_stat/stat_ads_model', "StatAds");
        $this->load->model('set_stat/money_model', "Money");

        $this->load->model('views_filter_model');
        $this->load->model('unit2_model', "Units");
        $this->load->model('ads2_model', "Ads");
        $this->load->model('site2_model', "Site");
    }


    public function index()
    {
        $start = microtime(true);

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

        if ($this->input->is_ajax_request()) {

            $site_obj = $this->Site->get([
                "domain" => $this->request->referer_domain
            ]);

            // активен ли сайт
            if ($site_obj && $site_obj->status != 1) {
                exit("inactive site");
            }

            foreach ((object) json_decode($this->input->post('units')) as $unit) {

                // проверим все ли параметры пришли
                if (empty($unit->uid) || empty($unit->aids) || empty($unit->hmac) || empty($unit->time)) {
                    $error = "Adflex: missing required parameters";
                    continue;
                }

                // проверим подпись данных
                $hmac = md5(serialize([
                    'unit_hash'      => $unit->uid,
                    'ads_hashes'     => implode(',', (array) $unit->aids),
                    'client_ip'      => $this->request->client_ip,
                    'useragent'      => $this->request->useragent,
                    'referer_domain' => $this->request->referer_domain,
                    'time'           => $unit->time,
                    'appkey'         => $GLOBALS['adflex']['appkey'] // secret
                ]));

                //
                if (!hash_equals($hmac, $unit->hmac)) {
                    $error = "Adflex: invalid hmac";
                    continue;
                }

                // проверим не протухла ли подпись
                if ((time() - $unit->time) > config_item('ad_hmac_expiration')) {
                    $error = "Adflex: hmac expired";
                    continue;
                }


                //---------------------------------------------------------------

                $unit_obj = $this->Units->get(['hash_id' => $unit->uid]);
                $ads_obj  = $this->Ads->fetch_where_in('hash_id', $unit->aids);
                $site_obj = $this->Site->get(['domain' => $this->request->referer_domain]);


                if (!$unit_obj) {
                    $error = "Adflex: unit not found";
                    continue;
                }


                // default 200 unit views per IP
                if (config_item('enable_views_filter') && $this->views_filter_model->is_bad_unit_view($unit_obj->unit_id)) {
                    $error = "Adflex: bad unit view";
                    continue;
                }

                // проверка каждого обьявления на превышение количества показов для этого ip
                foreach ($ads_obj as & $ad_obj) {

                    if (config_item('enable_views_filter') && $this->views_filter_model->is_bad_ad_view($ad_obj->ad_id)) {
                        unset($ad_obj);
                        $error = "Adflex: bad ad view";
                        continue;
                    }
                }

                if (!$ads_obj) {
                    $error = "Adflex: ads not found";
                    continue;
                }

                // isolated сайт - статистику считаем, деньги не списываем
                if ($site_obj->isolated) {

                    $this->StatUnit->money(false)->set_view($unit_obj, $ads_obj);
                    $this->StatSite->money(false)->set_view($unit_obj, $ads_obj);
                    $this->StatWebmaster->money(false)->set_view($unit_obj, $ads_obj);
                    $this->StatCamp->money(false)->set_view($unit_obj, $ads_obj);
                    $this->StatAdvertiser->money(false)->set_view($unit_obj, $ads_obj);
                    $this->StatAd->money(false)->set_view($unit_obj, $ads_obj);
                    $this->StatAds->money(false)->set_view($unit_obj, $ads_obj); // статистика прямо в таблицу обьявлений
                    $this->Money->money(false)->set_view($unit_obj, $ads_obj);
                } // все проверки пройдены, запишем показ в статистику
                else {

                    $this->StatUnit->set_view($unit_obj, $ads_obj);
                    $this->StatSite->set_view($unit_obj, $ads_obj);
                    $this->StatWebmaster->set_view($unit_obj, $ads_obj);
                    $this->StatCamp->set_view($unit_obj, $ads_obj);
                    $this->StatAdvertiser->set_view($unit_obj, $ads_obj);
                    $this->StatAd->set_view($unit_obj, $ads_obj);
                    $this->StatAds->set_view($unit_obj, $ads_obj); // статистика прямо в таблицу обьявлений
                    $this->Money->set_view($unit_obj, $ads_obj);
                }
            }

            // debug section
            if ($this->input->post('debug') == 1) {

                $debug_info = [
                    'error'       => isset($error) ? $error : "",
                    'query_count' => $this->db->query_count,
                    'query_time'  => round($this->db->benchmark, 4),
                    'elapsed'     => round(microtime(true) - $start, 4)
                ];

                exit(json_encode($debug_info, JSON_PRETTY_PRINT));
            }
        }
    }
}
