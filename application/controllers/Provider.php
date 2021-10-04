<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Provider extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('unit2_model', 'Unit2');
        $this->load->model('target_banner_model', 'Target_banner');
        $this->load->model('target_ad_model', 'Target_ad');
        $this->load->model('site2_model', "Site");
    }


    public function index()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        header('Content-Type: application/json');
        header("Cache-Control: no-cache, no-store, must-revalidate");
        header("Pragma: no-cache");
        header("Expires: 0");

        if ($this->input->is_ajax_request()) {

            $start          = microtime(true);
            $output         = [];
            $units_hash_ids = explode(',', (string) $this->input->post_get('units_hash_ids'));

            $site_obj = $this->Site->get([
                "domain" => $this->request->referer_domain
            ]);

            // активен ли сайт
            if ($site_obj && $site_obj->status != 1) {
                exit(json_encode([
                    'units' => null,
                    'descr' => "site inactive"
                ], JSON_PRETTY_PRINT));
            }

            if (!$units_hash_ids) {
                exit(json_encode([
                    'units' => null,
                    'descr' => "error input params"
                ], JSON_PRETTY_PRINT));
            }

            // fetch Units objects
            foreach ($this->Unit2->fetch_where_in('hash_id', $units_hash_ids, ['status' => 1]) as $unit_obj) {

                // check referer domain
                if ($unit_obj->site()->domain != $this->request->referer_domain) {
                    continue;
                }

                // get banner
                if ($unit_obj->type === "banner" && $banner_obj = $this->Target_banner->get($unit_obj)) {

                    $time = strval(time());

                    $output[$unit_obj->hash_id] = [
                        'data'   => $this->adding_ad_link($banner_obj, $unit_obj),
                        'time'   => $time,
                        'params' => $this->getThirdPartyCode($site_obj, $unit_obj),
                        //
                        'hmac'   => md5(serialize([
                            'unit_hash'      => $unit_obj->hash_id,
                            'ads_hashes'     => implode(',', (array) $banner_obj->hash_id),
                            'client_ip'      => $this->request->client_ip,
                            'useragent'      => $this->request->useragent,
                            'referer_domain' => $this->request->referer_domain,
                            'time'           => $time,
                            'appkey'         => $GLOBALS['adflex']['appkey'] // secret
                        ]))
                    ];
                } // get ad or mobile
                elseif (($unit_obj->type === "ad" || $unit_obj->type === "mobile") && $ad_obj = $this->Target_ad->get($unit_obj)) {

                    $time = strval(time());

                    $output[$unit_obj->hash_id] = [
                        'data'   => $this->adding_ad_link($ad_obj, $unit_obj),
                        'params' => $this->getThirdPartyCode($site_obj, $unit_obj),
                        'time'   => $time,
                        //
                        'hmac'   => md5(serialize([
                            'unit_hash'      => $unit_obj->hash_id,
                            'ads_hashes'     => implode(',', (array) $ad_obj->hash_id),
                            'client_ip'      => $this->request->client_ip,
                            'useragent'      => $this->request->useragent,
                            'referer_domain' => $this->request->referer_domain,
                            'time'           => $time,
                            'appkey'         => $GLOBALS['adflex']['appkey'] // secret
                        ]))
                    ];
                } // даже если подходящих баннеров нет, мы должны вернуть данные рекламного блока
                else {

                    $time = strval(time());

                    $output[$unit_obj->hash_id] = [
                        'data'   => null,
                        'params' => $this->getThirdPartyCode($site_obj, $unit_obj),
                        'time'   => $time,
                        //
                        'hmac'   => md5(serialize([
                            'unit_hash'      => $unit_obj->hash_id,
                            'ads_hashes'     => null,
                            'client_ip'      => $this->request->client_ip,
                            'useragent'      => $this->request->useragent,
                            'referer_domain' => $this->request->referer_domain,
                            'time'           => $time,
                            'appkey'         => $GLOBALS['adflex']['appkey'] // secret
                        ]))
                    ];

                }
            }

            $output["visible_tip"] = get_globalsettings("adunit_visible_tip", 0);

            // debug
            if ($this->input->get_post('debug') == 1) {

                $debug_info = [
                    'units'       => $output,
                    'elapsed'     => round(microtime(true) - $start, 4),
                    'query_count' => $this->db->query_count,
                    'query_time'  => round($this->db->benchmark, 4)
                ];

                exit(json_encode($debug_info, JSON_PRETTY_PRINT));
            } else {
                exit(json_encode(['units' => $output], JSON_PRETTY_PRINT));
            }
        }
    }


    private function adding_ad_link($banner_obj, $unit_obj)
    {
        $time = strval(time());


        $link_data['link'] = http_build_query([
            'aid'  => $banner_obj->hash_id,
            'uid'  => $unit_obj->hash_id,
            'time' => $time,
            'hmac' => md5(serialize([
                'ad_hash'        => $banner_obj->hash_id,
                'unit_hash'      => $unit_obj->hash_id,
                'client_ip'      => $this->request->client_ip,
                'useragent'      => $this->request->useragent,
                'referer_domain' => $this->request->referer_domain,
                'time'           => $time,
                'appkey'         => $GLOBALS['adflex']['appkey'] // secret
            ]))
        ]);

        return array_merge((array) $banner_obj, $link_data);
    }


    private function getThirdPartyCode($site_obj, $unit_obj)
    {
        $unit_obj->params = json_decode($unit_obj->params);
        return $unit_obj->params;
    }

}
