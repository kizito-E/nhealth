<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Click extends CI_Controller
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

        $this->load->model('clicks_filter_model');
        $this->load->model('unit2_model', "Unit2");
        $this->load->model('ads2_model', "Ads2");
    }


    public function index()
    {
        $errors = [];

        $ad_hash   = $this->input->get('aid');
        $unit_hash = $this->input->get('uid');
        $time      = $this->input->get('time');
        $hmac      = $this->input->get('hmac');

        // проверка цифровой подписи ссылки
        $key = md5(serialize([
            'ad_hash'        => $ad_hash,
            'unit_hash'      => $unit_hash,
            'client_ip'      => $this->request->client_ip,
            'useragent'      => $this->request->useragent,
            'referer_domain' => $this->request->referer_domain,
            'time'           => $time,
            'appkey'         => $GLOBALS['adflex']['appkey'] // secret
        ]));

        if (!hash_equals($hmac, $key)) {
            redirect(config_item('adflex'));  // Critical error - no further work possible
        }

        // Получаем обьекты блока и обьявления
        $unit_obj = $this->Unit2->get(['hash_id' => $unit_hash]);
        $ad_obj   = $this->Ads2->get(['hash_id' => $ad_hash]);

        // Проверка обьектов на пустоту
        if (!$unit_obj || !$ad_obj) {
            redirect(config_item('adflex'));  // Critical error - no further work possible
        }

        // Домен реферера должен совпадать с доменом рекламного блока
        if ($this->request->referer_domain !== $unit_obj->site()->domain) {
            $errors[] = "invalid_referer_domain";
        }

        // плохой ли это клик? не превышено ли количество кликов с этого IP по этому блоку и этому обьявлению
        if (config_item('enable_clicks_filter') && $this->clicks_filter_model->is_bad_click($ad_obj->ad_id, $unit_obj->unit_id)) {
            $errors[] = "click_limit_exceeded";
        }

        // плохой клик или isolated сайт - статистику считаем, деньги не списываем
        if ($errors || $unit_obj->site()->isolated == 1) {

            $this->StatUnit->money(false)->set_click($unit_obj, $ad_obj);
            $this->StatSite->money(false)->set_click($unit_obj, $ad_obj);
            $this->StatWebmaster->money(false)->set_click($unit_obj, $ad_obj);
            $this->StatCamp->money(false)->set_click($unit_obj, $ad_obj);
            $this->StatAdvertiser->money(false)->set_click($unit_obj, $ad_obj);
            $this->StatAd->money(false)->set_click($unit_obj, $ad_obj);
            $this->StatAds->money(false)->set_click($unit_obj, $ad_obj); // статистика прямо в таблицу обьявлений
            $this->Money->money(false)->set_click($unit_obj, $ad_obj);

            $this->go($unit_obj, $ad_obj);
        } // все проверки пройдены, запишем статистику
        else {

            $this->StatUnit->set_click($unit_obj, $ad_obj);
            $this->StatSite->set_click($unit_obj, $ad_obj);
            $this->StatWebmaster->set_click($unit_obj, $ad_obj);
            $this->StatCamp->set_click($unit_obj, $ad_obj);
            $this->StatAdvertiser->set_click($unit_obj, $ad_obj);
            $this->StatAd->set_click($unit_obj, $ad_obj);
            $this->StatAds->set_click($unit_obj, $ad_obj); // статистика прямо в таблицу обьявлений
            $this->Money->set_click($unit_obj, $ad_obj);

            $this->go($unit_obj, $ad_obj);
        }
    }


    // {site} - Подставит в ссылку домен.
    // {camp-id} - Подставит в ссылку ID кампании.
    // {ad-id} - Подставит в ссылку ID обьявления.
    // {date} - Подставит в ссылку дату клика в формате "Y-m-d".
    // {time} - Подставит в ссылку время клика в формате "H-i".
    // {fulltime} - Подставит в ссылку время клика в формате "H-i-s".
    // {device} - Подставит в ссылку тип устройства.
    private function go($unit_obj, $ad_obj)
    {
        $search = [
            '{site}',
            '{camp-id}',
            '{ad-id}',
            '{date}',
            '{time}',
            '{fulltime}',
            '{device}',
        ];

        $replace = [
            $unit_obj->site()->domain,
            $ad_obj->camp()->id,
            $ad_obj->ad_id,
            gmdate("Y-m-d"),
            gmdate("H-i"),
            gmdate("H-i-s"),
            $this->request->device_type
        ];

        $ad_url = str_replace($search, $replace, $ad_obj->ad_url);

        redirect($ad_url);
    }


}
