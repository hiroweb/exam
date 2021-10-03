<?php 

function IN_PRF($PRF_CD){
  $DB = new DB();
  $PT = new PT();
  $sql="SELECT PRF.*,
  MEM01.member_ID AS MEM01,
  MEM02.member_ID AS MEM02,
  OMS.OMS_name
  FROM prior_family AS PRF
  LEFT JOIN member AS MEM01 ON MEM01.person_NO = PRF.PRF_shinpai_person_NO AND PRF.PRF_shinpai_person_NO != 0
  LEFT JOIN member AS MEM02 ON MEM02.person_NO = PRF.PRF_irai_person_NO AND PRF.PRF_irai_person_NO != 0
  LEFT JOIN owner AS OMS ON OMS.owner_ID = PRF.PRFowner_ID
  WHERE PRF_CD ='$PRF_CD'";
  $res=$DB->query($sql);
  if($res){
    while($res=$DB->fetch_assoc()){
      if($res['MEM01']){
        $res['MEM01_star']='<img src="image/member.png" style="width:14px;height:auto;" alt="">';
      }else{$res['MEM01_star']='';}

      if($res['MEM02']){
        $res['MEM02_star']='<img src="image/member.png" style="width:14px;height:auto;" alt="">';
      }else{$res['MEM02_star']='';}
      if($res['MEM01']||$res['MEM02']){
        $res['member_flag']=1;
      }

      if($res["PRF_shinpai_sei_kj"].$res["PRF_shinpai_mei_kj"].$res["PRF_shinpai_sei_kn"].$res["PRF_shinpai_mei_kn"].$res["PRF_shinpai_zokugara"]!=''){
        $res["is_shinpai"]=1;
      }else{
        $res["is_shinpai"]=0;
      }

      if($res["PRF_irai_sei_kj"].$res["PRF_irai_mei_kj"].$res["PRF_irai_sei_kn"].$res["PRF_irai_mei_kn"].$res["PRF_irai_zokugara"]!=''){
        $res["is_irai"]=1;
      }else{
        $res["is_irai"]=0;
      }
      /*table表示 */
      $res['table']='';
      if($res['is_shinpai']){
        $res['table'].='<table id="input">
                <tbody class="body_shinpai">
                  <tr>
                    <th rowspan="11" class="th_shinpai">ご心配な方</th>
                    <th>姓名</th>
                    <td>
                      '.$res["MEM01_star"].$res["PRF_shinpai_sei_kj"].$res["PRF_shinpai_mei_kj"].' '.$res["PRF_shinpai_sei_kn"].' '.$res["PRF_shinpai_mei_kn"].'
                    </td>
                    <th>性別　</th>
                    <td>
                      '.$PT->sex[$res["PRF_shinpai_sex"]].'
                    </td>
                  </tr>
                  
                  <tr>
                    <th>住所</th>
                    <td colspan="3">
                      〒'.$res["PRF_shinpai_postal"].'
                      '.$res["PRF_shinpai_prefecture"].$res["PRF_shinpai_city"].$res["PRF_shinpai_address"].$res["PRF_shinpai_bld"].'
                    </td>
                  </tr>
                  <tr>
                    <th>生年月日　</th>
                    <td>
                      '.$res["PRF_shinpai_birthdayJ"].'
                    </td>
                    <th>続柄　</th>
                    <td>
                    '.$PT->zok_PSN[$res["PRF_shinpai_zokugara"]].'
                    </td>
                  </tr>
        
                  <tr>
                    <th>電話番号　</th>
                    <td>
                      '.$res["PRF_shinpai_phone"].'
                    </td>
                    <th>携帯番号　</th>
                    <td>
                      '.$res["PRF_shinpai_mobile"].'
                    </td>
                  </tr>
                  <tr>
                    <th>FAX番号　</th>
                    <td>
                      '.$res["PRF_shinpai_fax"].'
                    </td>
                    <th>メール　</th>
                    <td>
                      '.$res["PRF_shinpai_email"].'
                    </td>
                  </tr>
                  <tr>
                    <th>
                      備考
                    </th>
                    <td colspan="3">
                      '.$res["PRF_shinpai_memo|nl2br"].'
                    </td>
                  </tr>
              </tbody>
        </table>';

      }else{
        $res['table'].='<table id="input">
        <tbody>
        <tr>
          <th class="th_shinpai" style="border:1px solid #d0d0d0;">ご心配な方</th>
          <td style="border:1px solid #d0d0d0;">ご心配な方の入力はありません。</td>
        </tr>
        </tbody>
      </table>';
      }

      if($res['is_irai']){
        $res['table'].="<table id=\"input\">
                <tbody class=\"body_irai\">
                  <tr>
                    <th rowspan=\"11\" class=\"th_irai\">ご依頼者</th>
                    <th>姓名</th>
                    <td>
                      {$res["MEM02_star"]}{$res["PRF_irai_sei_kj"]} {$res["PRF_irai_mei_kj"]} {$res["PRF_irai_sei_kn"]} {$res["PRF_irai_mei_kn"]}
                    </td>
                    <th>性別　</th>
                    <td>
                      {$PT->sex[$res["PRF_irai_sex"]]}
                    </td>
                  </tr>
                  
                  <tr>
                    <th>住所</th>
                    <td colspan=\"3\">
                      〒{$res["PRF_irai_postal"]}
                      {$res["PRF_irai_prefecture"]}{$res["PRF_irai_city"]}{$res["PRF_irai_address"]}{$res["PRF_irai_bld"]}
                    </td>
                  </tr>
                  <tr>
                    <th>生年月日　</th>
                    <td>
                      {$res["PRF_irai_birthdayJ"]}
                    </td>
                    <th>続柄　</th>
                    <td>
                      {$PT->zok_PSN[$res["PRF_irai_zokugara"]]}
                    </td>
                  </tr>
                  <tr>
                    <th>電話番号　</th>
                    <td>
                      {$res["PRF_irai_phone"]}
                    </td>
                    <th>携帯番号　</th>
                    <td>
                      {$res["PRF_irai_mobile"]}
                    </td>
                  </tr>
                  <tr>
                    <th>FAX番号　</th>
                    <td>
                      {$res["PRF_irai_fax"]}
                    </td>
                    <th>メール　</th>
                    <td>
                      {$res["PRF_irai_email"]}
                    </td>
                  </tr>
                  <tr>
                    <th>
                      備考
                    </th>
                    <td colspan=\"3\">
                      {$res["PRF_irai_memo|nl2br"]}
                    </td>
                  </tr>
              </tbody>
        </table>";

      }else{
        $res['table'].="<table id=\"input\">
        <tbody>
        <tr>
          <th class=\"th_irai\" style=\"border:1px solid #d0d0d0;\">ご依頼者</th>
          <td style=\"border:1px solid #d0d0d0;\">ご依頼者の入力はありません。</td>
        </tr>
        </tbody>
      </table>";
      }



      $result=$res;
      }
    return $result;
  }
}