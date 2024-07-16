<?php
// 목적지 API URL 설정
$base_url = "http://api.data.go.kr/openapi/tn_pubr_public_cltur_fstvl_api";

// 클라이언트로부터 전달된 GET 파라미터 가져오기
$pageNo = isset($_GET['pageNo']) ? $_GET['pageNo'] : '1';
$numOfRows = isset($_GET['numOfRows']) ? $_GET['numOfRows'] : '100';
$type = isset($_GET['type']) ? $_GET['type'] : 'JSON';
$fstvlNm = isset($_GET['fstvlNm']) ? $_GET['fstvlNm'] : '';
$opar = isset($_GET['opar']) ? $_GET['opar'] : '';
$fstvlStartDate = isset($_GET['fstvlStartDate']) ? $_GET['fstvlStartDate'] : '';
$fstvlEndDate = isset($_GET['fstvlEndDate']) ? $_GET['fstvlEndDate'] : '';
$fstvlCo = isset($_GET['fstvlCo']) ? $_GET['fstvlCo'] : '';
$mnnstNm = isset($_GET['mnnstNm']) ? $_GET['mnnstNm'] : '';
$auspcInsttNm = isset($_GET['auspcInsttNm']) ? $_GET['auspcInsttNm'] : '';
$suprtInsttNm = isset($_GET['suprtInsttNm']) ? $_GET['suprtInsttNm'] : '';
$phoneNumber = isset($_GET['phoneNumber']) ? $_GET['phoneNumber'] : '';
$homepageUrl = isset($_GET['homepageUrl']) ? $_GET['homepageUrl'] : '';
$relateInfo = isset($_GET['relateInfo']) ? $_GET['relateInfo'] : '';
$rdnmadr = isset($_GET['rdnmadr']) ? $_GET['rdnmadr'] : '';
$lnmadr = isset($_GET['lnmadr']) ? $_GET['lnmadr'] : '';
$latitude = isset($_GET['latitude']) ? $_GET['latitude'] : '';
$longitude = isset($_GET['longitude']) ? $_GET['longitude'] : '';
$referenceDate = isset($_GET['referenceDate']) ? $_GET['referenceDate'] : '';
$instt_code = isset($_GET['instt_code']) ? $_GET['instt_code'] : '';
$instt_nm = isset($_GET['instt_nm']) ? $_GET['instt_nm'] : '';

// 필수 파라미터 체크
if (empty($type)) {
    http_response_code(400);
    echo json_encode(["error" => "Missing required parameter: type"]);
    exit;
}

// 쿼리 스트링 생성
$query_params = http_build_query([
    'pageNo' => $pageNo,
    'numOfRows' => $numOfRows,
    'type' => $type,
    'fstvlNm' => $fstvlNm,
    'opar' => $opar,
    'fstvlStartDate' => $fstvlStartDate,
    'fstvlEndDate' => $fstvlEndDate,
    'fstvlCo' => $fstvlCo,
    'mnnstNm' => $mnnstNm,
    'auspcInsttNm' => $auspcInsttNm,
    'suprtInsttNm' => $suprtInsttNm,
    'phoneNumber' => $phoneNumber,
    'homepageUrl' => $homepageUrl,
    'relateInfo' => $relateInfo,
    'rdnmadr' => $rdnmadr,
    'lnmadr' => $lnmadr,
    'latitude' => $latitude,
    'longitude' => $longitude,
    'referenceDate' => $referenceDate,
    'instt_code' => $instt_code,
    'instt_nm' => $instt_nm,
]);

// 전체 URL 생성
$target_url = $base_url . '?' . $query_params;

// cURL 세션 초기화
$ch = curl_init();

// cURL 옵션 설정
curl_setopt($ch, CURLOPT_URL, $target_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// cURL 실행 및 응답 저장
$response = curl_exec($ch);

// 응답이 없는 경우 오류 처리
if ($response === false) {
    $error = curl_error($ch);
    curl_close($ch);
    http_response_code(500);
    echo json_encode(["error" => "API 요청 중 오류 발생: $error"]);
    exit;
}

// cURL 세션 닫기
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$content_type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
curl_close($ch);

// 응답 헤더 설정
header("Content-Type: $content_type");
http_response_code($http_code);

// 클라이언트에게 응답 전송
echo $response;
?>
