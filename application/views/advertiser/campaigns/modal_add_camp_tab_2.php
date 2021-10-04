<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="tab-pane" id="tab_2">

    <div class="form-group">
        <label>
            <?php _e('Разрешенные тематики сайтов'); ?>
            <i class="fa fa-question-circle text-primary"
               data-toggle="tooltip"
               title="<?php _e('Обьявления будут показаны только на сайтах выбранных тематик.'); ?>">
            </i>        
        </label>
        <select v-model="allowed_site_themes"
                class="selectpicker"
                multiple
                data-style="btn-default btn-flat"
                data-width="100%"
                data-size="12"
                data-actions-box="true"
                data-selected-text-format="count > 0">
            <option value='auto_moto'><?php _e('Авто / Мото'); ?></option>
            <option value='business_finance'><?php _e('Бизнес / Финансы'); ?></option>
            <option value='house_family'><?php _e('Дом /Семья'); ?></option>
            <option value='health_fitness'><?php _e('Здоровье / Фитнесс'); ?></option>
            <option value='games'><?php _e('Игры'); ?></option>
            <option value='career_work'><?php _e('Карьера / Работа'); ?></option>
            <option value='cinema'><?php _e('Кино'); ?></option>
            <option value='beauty_cosmetics'><?php _e('Красота / Косметика'); ?></option>
            <option value='cookery'><?php _e('Кулинария'); ?></option>
            <option value='fashion_clothes'><?php _e('Одежда / Мода'); ?></option>
            <option value='music'><?php _e('Музыка'); ?></option>
            <option value='the_property'><?php _e('Недвижимость'); ?></option>
            <option value='news'><?php _e('Новости'); ?></option>
            <option value='society'><?php _e('Общество'); ?></option>
            <option value='entertainment'><?php _e('Развлечения'); ?></option>
            <option value='sport'><?php _e('Спорт'); ?></option>
            <option value='science'><?php _e('Наука'); ?></option>
            <option value='goods'><?php _e('Товары'); ?></option>
            <option value='tourism'><?php _e('Туризм'); ?></option>
            <option value='other'><?php _e('Другое'); ?></option>
            <option value='adult'><?php _e('Для взрослых'); ?></option>
        </select>
    </div>                                 



    <div class="form-group">
        <label>
            <?php _e('География'); ?>
            <i class="fa fa-question-circle text-primary"
               data-toggle="tooltip"
               title="<?php _e('Обьявления будут показаны только посетителям из выбранных стран.'); ?>">
            </i> 
        </label>
        <select v-model="geos" multiple class="selectpicker"
                data-style="btn-default btn-flat"
                data-width="100%"
                data-size="12"
                data-actions-box="true"
                data-selected-text-format="count > 0"
                data-live-search="true">
            <option data-subtext="AF" value="AF" data-icon="ii af">Afghanistan</option>
            <option data-subtext="AX" value="AX" data-icon="ii ax">Aland Islands</option>
            <option data-subtext="AL" value="AL" data-icon="ii al">Albania</option>
            <option data-subtext="DZ" value="DZ" data-icon="ii dz">Algeria</option>
            <option data-subtext="AS" value="AS" data-icon="ii as">American Samoa</option>
            <option data-subtext="AD" value="AD" data-icon="ii ad">Andorra</option>
            <option data-subtext="AO" value="AO" data-icon="ii ao">Angola</option>
            <option data-subtext="AI" value="AI" data-icon="ii ai">Anguilla</option>
            <option data-subtext="AQ" value="AQ" data-icon="ii aq">Antarctica</option>
            <option data-subtext="AG" value="AG" data-icon="ii ag">Antigua and Barbuda</option>
            <option data-subtext="AR" value="AR" data-icon="ii ar">Argentina</option>
            <option data-subtext="AM" value="AM" data-icon="ii am">Armenia</option>
            <option data-subtext="AW" value="AW" data-icon="ii aw">Aruba</option>
            <option data-subtext="AU" value="AU" data-icon="ii au">Australia</option>
            <option data-subtext="AT" value="AT" data-icon="ii at">Austria</option>
            <option data-subtext="AZ" value="AZ" data-icon="ii az">Azerbaijan</option>
            <option data-subtext="BS" value="BS" data-icon="ii bs">Bahamas</option>
            <option data-subtext="BH" value="BH" data-icon="ii bh">Bahrain</option>
            <option data-subtext="BD" value="BD" data-icon="ii bd">Bangladesh</option>
            <option data-subtext="BB" value="BB" data-icon="ii bb">Barbados</option>
            <option data-subtext="BY" value="BY" data-icon="ii by">Belarus</option>
            <option data-subtext="BE" value="BE" data-icon="ii be">Belgium</option>
            <option data-subtext="BZ" value="BZ" data-icon="ii bz">Belize</option>
            <option data-subtext="BJ" value="BJ" data-icon="ii bj">Benin</option>
            <option data-subtext="BM" value="BM" data-icon="ii bm">Bermuda</option>
            <option data-subtext="BT" value="BT" data-icon="ii bt">Bhutan</option>
            <option data-subtext="BO" value="BO" data-icon="ii bo">Bolivia (Plurinational State of)</option>
            <option data-subtext="BQ" value="BQ" data-icon="ii bq">Bonaire</option>
            <option data-subtext="BA" value="BA" data-icon="ii ba">Bosnia and Herzegovina</option>
            <option data-subtext="BW" value="BW" data-icon="ii bw">Botswana</option>
            <option data-subtext="BV" value="BV" data-icon="ii bv">Bouvet Island</option>
            <option data-subtext="BR" value="BR" data-icon="ii br">Brazil</option>
            <option data-subtext="IO" value="IO" data-icon="ii io">British Indian Ocean Territory</option>
            <option data-subtext="BN" value="BN" data-icon="ii bn">Brunei Darussalam</option>
            <option data-subtext="BG" value="BG" data-icon="ii bg">Bulgaria</option>
            <option data-subtext="BF" value="BF" data-icon="ii bf">Burkina Faso</option>
            <option data-subtext="BI" value="BI" data-icon="ii bi">Burundi</option>
            <option data-subtext="KH" value="KH" data-icon="ii kh">Cambodia</option>
            <option data-subtext="CM" value="CM" data-icon="ii cm">Cameroon</option>
            <option data-subtext="CA" value="CA" data-icon="ii ca">Canada</option>
            <option data-subtext="CV" value="CV" data-icon="ii cv">Cabo Verde</option>
            <option data-subtext="KY" value="KY" data-icon="ii ky">Cayman Islands</option>
            <option data-subtext="CF" value="CF" data-icon="ii cf">Central African Republic</option>
            <option data-subtext="TD" value="TD" data-icon="ii td">Chad</option>
            <option data-subtext="CL" value="CL" data-icon="ii cl">Chile</option>
            <option data-subtext="CN" value="CN" data-icon="ii cn">China</option>
            <option data-subtext="CX" value="CX" data-icon="ii cx">Christmas Island</option>
            <option data-subtext="CC" value="CC" data-icon="ii cc">Cocos (Keeling) Islands</option>
            <option data-subtext="CO" value="CO" data-icon="ii co">Colombia</option>
            <option data-subtext="KM" value="KM" data-icon="ii km">Comoros</option>
            <option data-subtext="CG" value="CG" data-icon="ii cg">Congo</option>
            <option data-subtext="CD" value="CD" data-icon="ii cd">Congo (Democratic Republic of the)</option>
            <option data-subtext="CK" value="CK" data-icon="ii ck">Cook Islands</option>
            <option data-subtext="CR" value="CR" data-icon="ii cr">Costa Rica</option>
            <option data-subtext="CI" value="CI" data-icon="ii ci">Cote d`Ivoire</option>
            <option data-subtext="HR" value="HR" data-icon="ii hr">Croatia</option>
            <option data-subtext="CU" value="CU" data-icon="ii cu">Cuba</option>
            <option data-subtext="CW" value="CW" data-icon="ii cw">Curacao</option>
            <option data-subtext="CY" value="CY" data-icon="ii cy">Cyprus</option>
            <option data-subtext="CZ" value="CZ" data-icon="ii cz">Czech Republic</option>
            <option data-subtext="DK" value="DK" data-icon="ii dk">Denmark</option>
            <option data-subtext="DJ" value="DJ" data-icon="ii dj">Djibouti</option>
            <option data-subtext="DM" value="DM" data-icon="ii dm">Dominica</option>
            <option data-subtext="DO" value="DO" data-icon="ii do">Dominican Republic</option>
            <option data-subtext="EC" value="EC" data-icon="ii ec">Ecuador</option>
            <option data-subtext="EG" value="EG" data-icon="ii eg">Egypt</option>
            <option data-subtext="SV" value="SV" data-icon="ii sv">El Salvador</option>
            <option data-subtext="GQ" value="GQ" data-icon="ii gq">Equatorial Guinea</option>
            <option data-subtext="ER" value="ER" data-icon="ii er">Eritrea</option>
            <option data-subtext="EE" value="EE" data-icon="ii ee">Estonia</option>
            <option data-subtext="ET" value="ET" data-icon="ii et">Ethiopia</option>
            <option data-subtext="FK" value="FK" data-icon="ii fk">Falkland Islands (Malvinas)</option>
            <option data-subtext="FO" value="FO" data-icon="ii fo">Faroe Islands</option>
            <option data-subtext="FJ" value="FJ" data-icon="ii fj">Fiji</option>
            <option data-subtext="FI" value="FI" data-icon="ii fi">Finland</option>
            <option data-subtext="FR" value="FR" data-icon="ii fr">France</option>
            <option data-subtext="GF" value="GF" data-icon="ii gf">French Guiana</option>
            <option data-subtext="PF" value="PF" data-icon="ii pf">French Polynesia</option>
            <option data-subtext="TF" value="TF" data-icon="ii tf">French Southern Territories</option>
            <option data-subtext="GA" value="GA" data-icon="ii ga">Gabon</option>
            <option data-subtext="GM" value="GM" data-icon="ii gm">Gambia</option>
            <option data-subtext="GE" value="GE" data-icon="ii ge">Georgia</option>
            <option data-subtext="DE" value="DE" data-icon="ii de">Germany</option>
            <option data-subtext="GH" value="GH" data-icon="ii gh">Ghana</option>
            <option data-subtext="GI" value="GI" data-icon="ii gi">Gibraltar</option>
            <option data-subtext="GR" value="GR" data-icon="ii gr">Greece</option>
            <option data-subtext="GL" value="GL" data-icon="ii gl">Greenland</option>
            <option data-subtext="GD" value="GD" data-icon="ii gd">Grenada</option>
            <option data-subtext="GP" value="GP" data-icon="ii gp">Guadeloupe</option>
            <option data-subtext="GU" value="GU" data-icon="ii gu">Guam</option>
            <option data-subtext="GT" value="GT" data-icon="ii gt">Guatemala</option>
            <option data-subtext="GG" value="GG" data-icon="ii gg">Guernsey</option>
            <option data-subtext="GN" value="GN" data-icon="ii gn">Guinea</option>
            <option data-subtext="GW" value="GW" data-icon="ii gw">Guinea-Bissau</option>
            <option data-subtext="GY" value="GY" data-icon="ii gy">Guyana</option>
            <option data-subtext="HT" value="HT" data-icon="ii ht">Haiti</option>
            <option data-subtext="HM" value="HM" data-icon="ii hm">Heard Island and McDonald Islands</option>
            <option data-subtext="VA" value="VA" data-icon="ii va">Holy See</option>
            <option data-subtext="HN" value="HN" data-icon="ii hn">Honduras</option>
            <option data-subtext="HK" value="HK" data-icon="ii hk">Hong Kong</option>
            <option data-subtext="HU" value="HU" data-icon="ii hu">Hungary</option>
            <option data-subtext="IS" value="IS" data-icon="ii is">Iceland</option>
            <option data-subtext="IN" value="IN" data-icon="ii _in">India</option>
            <option data-subtext="ID" value="ID" data-icon="ii id">Indonesia</option>
            <option data-subtext="IR" value="IR" data-icon="ii ir">Iran (Islamic Republic of)</option>
            <option data-subtext="IQ" value="IQ" data-icon="ii iq">Iraq</option>
            <option data-subtext="IE" value="IE" data-icon="ii ie">Ireland</option>
            <option data-subtext="IM" value="IM" data-icon="ii im">Isle of Man</option>
            <option data-subtext="IL" value="IL" data-icon="ii il">Israel</option>
            <option data-subtext="IT" value="IT" data-icon="ii it">Italy</option>
            <option data-subtext="JM" value="JM" data-icon="ii jm">Jamaica</option>
            <option data-subtext="JP" value="JP" data-icon="ii jp">Japan</option>
            <option data-subtext="JE" value="JE" data-icon="ii je">Jersey</option>
            <option data-subtext="JO" value="JO" data-icon="ii jo">Jordan</option>
            <option data-subtext="KZ" value="KZ" data-icon="ii kz">Kazakhstan</option>
            <option data-subtext="KE" value="KE" data-icon="ii ke">Kenya</option>
            <option data-subtext="KI" value="KI" data-icon="ii ki">Kiribati</option>
            <option data-subtext="KP" value="KP" data-icon="ii kp">Korea (Democratic People`s Republic of)</option>
            <option data-subtext="KR" value="KR" data-icon="ii kr">Korea (Republic of)</option>
            <option data-subtext="KW" value="KW" data-icon="ii kw">Kuwait</option>
            <option data-subtext="KG" value="KG" data-icon="ii kg">Kyrgyzstan</option>
            <option data-subtext="LA" value="LA" data-icon="ii la">Lao People`s Democratic Republic</option>
            <option data-subtext="LV" value="LV" data-icon="ii lv">Latvia</option>
            <option data-subtext="LB" value="LB" data-icon="ii lb">Lebanon</option>
            <option data-subtext="LS" value="LS" data-icon="ii ls">Lesotho</option>
            <option data-subtext="LR" value="LR" data-icon="ii lr">Liberia</option>
            <option data-subtext="LY" value="LY" data-icon="ii ly">Libya</option>
            <option data-subtext="LI" value="LI" data-icon="ii li">Liechtenstein</option>
            <option data-subtext="LT" value="LT" data-icon="ii lt">Lithuania</option>
            <option data-subtext="LU" value="LU" data-icon="ii lu">Luxembourg</option>
            <option data-subtext="MO" value="MO" data-icon="ii mo">Macao</option>
            <option data-subtext="MK" value="MK" data-icon="ii mk">Macedonia</option>
            <option data-subtext="MG" value="MG" data-icon="ii mg">Madagascar</option>
            <option data-subtext="MW" value="MW" data-icon="ii mw">Malawi</option>
            <option data-subtext="MY" value="MY" data-icon="ii my">Malaysia</option>
            <option data-subtext="MV" value="MV" data-icon="ii mv">Maldives</option>
            <option data-subtext="ML" value="ML" data-icon="ii ml">Mali</option>
            <option data-subtext="MT" value="MT" data-icon="ii mt">Malta</option>
            <option data-subtext="MH" value="MH" data-icon="ii mh">Marshall Islands</option>
            <option data-subtext="MQ" value="MQ" data-icon="ii mq">Martinique</option>
            <option data-subtext="MR" value="MR" data-icon="ii mr">Mauritania</option>
            <option data-subtext="MU" value="MU" data-icon="ii mu">Mauritius</option>
            <option data-subtext="YT" value="YT" data-icon="ii yt">Mayotte</option>
            <option data-subtext="MX" value="MX" data-icon="ii mx">Mexico</option>
            <option data-subtext="FM" value="FM" data-icon="ii fm">Micronesia (Federated States of)</option>
            <option data-subtext="MD" value="MD" data-icon="ii md">Moldova (Republic of)</option>
            <option data-subtext="MC" value="MC" data-icon="ii mc">Monaco</option>
            <option data-subtext="MN" value="MN" data-icon="ii mn">Mongolia</option>
            <option data-subtext="ME" value="ME" data-icon="ii me">Montenegro</option>
            <option data-subtext="MS" value="MS" data-icon="ii ms">Montserrat</option>
            <option data-subtext="MA" value="MA" data-icon="ii ma">Morocco</option>
            <option data-subtext="MZ" value="MZ" data-icon="ii mz">Mozambique</option>
            <option data-subtext="MM" value="MM" data-icon="ii mm">Myanmar</option>
            <option data-subtext="NA" value="NA" data-icon="ii na">Namibia</option>
            <option data-subtext="NR" value="NR" data-icon="ii nr">Nauru</option>
            <option data-subtext="NP" value="NP" data-icon="ii np">Nepal</option>
            <option data-subtext="NL" value="NL" data-icon="ii nl">Netherlands</option>
            <option data-subtext="NC" value="NC" data-icon="ii nc">New Caledonia</option>
            <option data-subtext="NZ" value="NZ" data-icon="ii nz">New Zealand</option>
            <option data-subtext="NI" value="NI" data-icon="ii ni">Nicaragua</option>
            <option data-subtext="NE" value="NE" data-icon="ii ne">Niger</option>
            <option data-subtext="NG" value="NG" data-icon="ii ng">Nigeria</option>
            <option data-subtext="NU" value="NU" data-icon="ii nu">Niue</option>
            <option data-subtext="NF" value="NF" data-icon="ii nf">Norfolk Island</option>
            <option data-subtext="MP" value="MP" data-icon="ii mp">Northern Mariana Islands</option>
            <option data-subtext="NO" value="NO" data-icon="ii no">Norway</option>
            <option data-subtext="OM" value="OM" data-icon="ii om">Oman</option>
            <option data-subtext="PK" value="PK" data-icon="ii pk">Pakistan</option>
            <option data-subtext="PW" value="PW" data-icon="ii pw">Palau</option>
            <option data-subtext="PS" value="PS" data-icon="ii ps">Palestine</option>
            <option data-subtext="PA" value="PA" data-icon="ii pa">Panama</option>
            <option data-subtext="PG" value="PG" data-icon="ii pg">Papua New Guinea</option>
            <option data-subtext="PY" value="PY" data-icon="ii py">Paraguay</option>
            <option data-subtext="PE" value="PE" data-icon="ii pe">Peru</option>
            <option data-subtext="PH" value="PH" data-icon="ii ph">Philippines</option>
            <option data-subtext="PN" value="PN" data-icon="ii pn">Pitcairn</option>
            <option data-subtext="PL" value="PL" data-icon="ii pl">Poland</option>
            <option data-subtext="PT" value="PT" data-icon="ii pt">Portugal</option>
            <option data-subtext="PR" value="PR" data-icon="ii pr">Puerto Rico</option>
            <option data-subtext="QA" value="QA" data-icon="ii qa">Qatar</option>
            <option data-subtext="RE" value="RE" data-icon="ii re">Reunion</option>
            <option data-subtext="RO" value="RO" data-icon="ii ro">Romania</option>
            <option data-subtext="RU" value="RU" data-icon="ii ru">Russian Federation</option>
            <option data-subtext="RW" value="RW" data-icon="ii rw">Rwanda</option>
            <option data-subtext="BL" value="BL" data-icon="ii bl">Saint Barthelemy</option>
            <option data-subtext="SH" value="SH" data-icon="ii sh">Saint Helena</option>
            <option data-subtext="KN" value="KN" data-icon="ii kn">Saint Kitts and Nevis</option>
            <option data-subtext="LC" value="LC" data-icon="ii lc">Saint Lucia</option>
            <option data-subtext="MF" value="MF" data-icon="ii mf">Saint Martin (French part)</option>
            <option data-subtext="PM" value="PM" data-icon="ii pm">Saint Pierre and Miquelon</option>
            <option data-subtext="VC" value="VC" data-icon="ii vc">Saint Vincent and the Grenadines</option>
            <option data-subtext="WS" value="WS" data-icon="ii ws">Samoa</option>
            <option data-subtext="SM" value="SM" data-icon="ii sm">San Marino</option>
            <option data-subtext="ST" value="ST" data-icon="ii st">Sao Tome and Principe</option>
            <option data-subtext="SA" value="SA" data-icon="ii sa">Saudi Arabia</option>
            <option data-subtext="SN" value="SN" data-icon="ii sn">Senegal</option>
            <option data-subtext="RS" value="RS" data-icon="ii rs">Serbia</option>
            <option data-subtext="SC" value="SC" data-icon="ii sc">Seychelles</option>
            <option data-subtext="SL" value="SL" data-icon="ii sl">Sierra Leone</option>
            <option data-subtext="SG" value="SG" data-icon="ii sg">Singapore</option>
            <option data-subtext="SX" value="SX" data-icon="ii sx">Sint Maarten (Dutch part)</option>
            <option data-subtext="SK" value="SK" data-icon="ii sk">Slovakia</option>
            <option data-subtext="SI" value="SI" data-icon="ii si">Slovenia</option>
            <option data-subtext="SB" value="SB" data-icon="ii sb">Solomon Islands</option>
            <option data-subtext="SO" value="SO" data-icon="ii so">Somalia</option>
            <option data-subtext="ZA" value="ZA" data-icon="ii za">South Africa</option>
            <option data-subtext="GS" value="GS" data-icon="ii gs">South Georgia and the South Sandwich Islands</option>
            <option data-subtext="SS" value="SS" data-icon="ii ss">South Sudan</option>
            <option data-subtext="ES" value="ES" data-icon="ii es">Spain</option>
            <option data-subtext="LK" value="LK" data-icon="ii lk">Sri Lanka</option>
            <option data-subtext="SD" value="SD" data-icon="ii sd">Sudan</option>
            <option data-subtext="SR" value="SR" data-icon="ii sr">Suriname</option>
            <option data-subtext="SJ" value="SJ" data-icon="ii sj">Svalbard and Jan Mayen</option>
            <option data-subtext="SZ" value="SZ" data-icon="ii sz">Swaziland</option>
            <option data-subtext="SE" value="SE" data-icon="ii se">Sweden</option>
            <option data-subtext="CH" value="CH" data-icon="ii ch">Switzerland</option>
            <option data-subtext="SY" value="SY" data-icon="ii sy">Syrian Arab Republic</option>
            <option data-subtext="TW" value="TW" data-icon="ii tw">Taiwan (Province of China)</option>
            <option data-subtext="TJ" value="TJ" data-icon="ii tj">Tajikistan</option>
            <option data-subtext="TZ" value="TZ" data-icon="ii tz">Tanzania</option>
            <option data-subtext="TH" value="TH" data-icon="ii th">Thailand</option>
            <option data-subtext="TL" value="TL" data-icon="ii tl">Timor-Leste</option>
            <option data-subtext="TG" value="TG" data-icon="ii tg">Togo</option>
            <option data-subtext="TK" value="TK" data-icon="ii tk">Tokelau</option>
            <option data-subtext="TO" value="TO" data-icon="ii to">Tonga</option>
            <option data-subtext="TT" value="TT" data-icon="ii tt">Trinidad and Tobago</option>
            <option data-subtext="TN" value="TN" data-icon="ii tn">Tunisia</option>
            <option data-subtext="TR" value="TR" data-icon="ii tr">Turkey</option>
            <option data-subtext="TM" value="TM" data-icon="ii tm">Turkmenistan</option>
            <option data-subtext="TC" value="TC" data-icon="ii tc">Turks and Caicos Islands</option>
            <option data-subtext="TV" value="TV" data-icon="ii tv">Tuvalu</option>
            <option data-subtext="UG" value="UG" data-icon="ii ug">Uganda</option>
            <option data-subtext="UA" value="UA" data-icon="ii ua">Ukraine</option>
            <option data-subtext="AE" value="AE" data-icon="ii ae">United Arab Emirates</option>
            <option data-subtext="GB" value="GB" data-icon="ii gb">United Kingdom of Great Britain and Northern Ireland</option>
            <option data-subtext="US" value="US" data-icon="ii us">United States of America</option>
            <option data-subtext="UM" value="UM" data-icon="ii um">United States Minor Outlying Islands</option>
            <option data-subtext="UY" value="UY" data-icon="ii uy">Uruguay</option>
            <option data-subtext="UZ" value="UZ" data-icon="ii uz">Uzbekistan</option>
            <option data-subtext="VU" value="VU" data-icon="ii vu">Vanuatu</option>
            <option data-subtext="VE" value="VE" data-icon="ii ve">Venezuela (Bolivarian Republic of)</option>
            <option data-subtext="VN" value="VN" data-icon="ii vn">Viet Nam</option>
            <option data-subtext="VG" value="VG" data-icon="ii vg">Virgin Islands (British)</option>
            <option data-subtext="VI" value="VI" data-icon="ii vi">Virgin Islands (U.S.)</option>
            <option data-subtext="WF" value="WF" data-icon="ii wf">Wallis and Futuna</option>
            <option data-subtext="EH" value="EH" data-icon="ii eh">Western Sahara</option>
            <option data-subtext="YE" value="YE" data-icon="ii ye">Yemen</option>
            <option data-subtext="ZM" value="ZM" data-icon="ii zm">Zambia</option>
            <option data-subtext="ZW" value="ZW" data-icon="ii zw">Zimbabwe</option>
        </select>
    </div>

    <div class="form-group">
        <label>
            <?php _e('Устройства'); ?>
            <i class="fa fa-question-circle text-primary"
               data-toggle="tooltip"
               title="<?php _e('Обьявления будут показаны только на выбранных устройствах.'); ?>">
            </i> 
        </label>
        <select v-model="devs" multiple class="selectpicker"
                data-style="btn-default btn-flat"
                data-width="100%"
                data-size="12"
                data-actions-box="true"
                data-selected-text-format="count > 0">
            <option data-icon="ii computer" value="Computer">Computer</option>
            <option data-icon="ii tablet" value="Tablet">Tablet</option>
            <option data-icon="ii mobile" value="Mobile">Mobile</option>
        </select>
    </div>

    <div class="form-group">
        <label>
            <?php _e('Платформы'); ?>
            <i class="fa fa-question-circle text-primary"
               data-toggle="tooltip"
               title="<?php _e('Обьявления будут показаны только на выбранных операционных системах.'); ?>">
            </i> 
        </label>
        <select v-model="platforms" multiple class="selectpicker"
                data-style="btn-default btn-flat"
                data-width="100%"
                data-size="12"
                data-actions-box="true"
                data-selected-text-format="count > 0">
            <optgroup label="Desktop OS">
                <option data-icon="ii windows_10" value="Windows_10">Windows 10</option>
                <option data-icon="ii windows_8" value="Windows_8_1">Windows 8.1</option>
                <option data-icon="ii windows_8" value="Windows_8">Windows 8</option>
                <option data-icon="ii windows_7" value="Windows_7">Windows 7</option>
                <option data-icon="ii windows_vista" value="Windows_Vista">Windows Vista</option>
                <option data-icon="ii windows_xp" value="Windows_XP">Windows XP</option>
                <option data-icon="ii apple" value="Mac_OS">Mac OS</option>
                <option data-icon="ii ubuntu" value="Ubuntu">Ubuntu</option>
                <option data-icon="ii linux" value="Linux">Linux</option>
                <option data-icon="ii computer" value="unknown_desktop_os">Other desktop OS</option>
            </optgroup>
            <optgroup label="Mobile OS">
                <option data-icon="ii apple" value="iOS">iOS</option>
                <option data-icon="ii android" value="Android">Android</option>
                <option data-icon="ii windows_phone" value="Windows_Phone">Windows Phone</option>
                <option data-icon="ii symbian" value="Symbian">Symbian</option>
                <option data-icon="ii black_berry" value="Black_Berry">Black Berry</option>
                <option data-icon="ii windows_xp" value="Windows_Mobile">Windows Mobile</option>
                <option data-icon="ii mobile" value="unknown_mobile_os">Other mobile OS</option>
            </optgroup>
        </select>
    </div>

    <div class="form-group">
        <label>
            <?php _e('Браузеры'); ?>
            <i class="fa fa-question-circle text-primary"
               data-toggle="tooltip"
               title="<?php _e('Обьявления будут показаны только на выбранных браузерах.'); ?>">
            </i> 
        </label>
        <select v-model="browsers" multiple class="selectpicker"
                data-style="btn-default btn-flat"
                data-width="100%"
                data-size="12"
                data-actions-box="true"
                data-selected-text-format="count > 0">
            <optgroup label="Desktop browsers">
                <option data-icon="ii chrome" value="Chrome_d">Chrome</option>
                <option data-icon="ii firefox" value="Firefox_d">Firefox</option>
                <option data-icon="ii opera" value="Opera_d">Opera</option>
                <option data-icon="ii iexplorer" value="IE_d">IE</option>
                <option data-icon="ii edge" value="Edge_d">Edge</option>
                <option data-icon="ii maxthon" value="Maxthon_d">Maxthon</option>
                <option data-icon="ii safari" value="Safari_d">Safari</option>
                <option data-icon="ii computer" value="unknown_desktop_browser">Other desktop browsers</option>
            </optgroup>
            <optgroup label="Mobile browsers">
                <option data-icon="ii chrome" value="Chrome_m">Chrome </option>
                <option data-icon="ii android_browser" value="Android_m">Android browser</option>
                <option data-icon="ii opera" value="Opera_m">Opera</option>
                <option data-icon="ii dolphin" value="Dolphin_m">Dolphin</option>
                <option data-icon="ii firefox" value="Firefox_m">Firefox</option>
                <option data-icon="ii uc_browser" value="UCBrowser_m">UCBrowser</option>
                <option data-icon="ii puffin" value="Puffin_m">Puffin</option>
                <option data-icon="ii safari" value="Safari_m">Safari</option>
                <option data-icon="ii edge" value="Edge_m">Edge</option>
                <option data-icon="ii iexplorer" value="IE_m">IE</option>
                <option data-icon="ii mobile" value="unknown_mobile_browser">Other mobile browsers</option>
            </optgroup>
        </select>
    </div>



</div>