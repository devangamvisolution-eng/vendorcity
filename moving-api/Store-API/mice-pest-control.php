<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://vendorscity.com/beta/api/store-garden-pest-control',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "service_id": 47,
    "subservice_id": 78,
    "city_id": 22,
    "service_type": "Landscaping",
    "service_date": "2026-08-31",
    "address": "Ahm25, Akshar Road, Near Shivam Tower, Andheri, Mumbai.edabad",
    "type_of_home": "Villa",
    "size_of_home_id": 57,
    "size_of_home_1": "4 BR",
    "describe_your_requirements": "Lorem Ipsum"
}
',
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL3ZlbmRvcnNjaXR5LmNvbS9iZXRhL2FwaS92MS9hdXRoL3ZlcmlmeS1vdHAiLCJpYXQiOjE3ODc2NDMxOTUsImV4cCI6MTc5MDIzNTE5NSwibmJmIjoxNzg3NjQzMTk1LCJqdGkiOiI0aVR6cko1WWdMYWFZM2ljIiwic3ViIjoiMSIsInBydiI6IjhjNWRhY2IzOWNhNjE3NzVmODBlZjQyZWM2MGRjMTM0ZjZjMDQ2ZGUifQ.CXrmN1m_KqpBs1q_bpktrR3O1jowlF79Q2GfXAreZrU',
    'Accept: application/json',
    'Content-Type: application/json',
    'Cookie: XSRF-TOKEN=eyJpdiI6Ik5Qb21GRStTQ09zVWo1NmVTNy9CQnc9PSIsInZhbHVlIjoiM1hWK1FhRS9wZ1prVmFUd3JIWWtqRCthQWRnTnY0TGVBT2ZITVhxenkzVGhjdUpqbXB3aHdaSTRCRFY1c1FVVlhMcXpEZmpWR2pyRlU2ZmhHTWM2d3dWc2JXVGVkVExJcU8xUVpQcWJmMjVoRllJSzdEZmw1TnBoUHFzVkM3R0YiLCJtYWMiOiIwMGI1MmQ1ZDVmYWZkOWRhMDBlMTllYzA4ZjAyZjYxYWRkYzIwZGE3OTdhMWExZTYxODQxOWZmM2I2ODNiZWQwIiwidGFnIjoiIn0%3D; vendorscity_session=eyJpdiI6IkJTSVpVek9leno2V0VXOUsrQktuMEE9PSIsInZhbHVlIjoidUNSWVpIaE1KbkZxRWhvUHNZNDdRVXEvNzFlcko4MzErb2wwcGxhMUZ6aC9XbEZlcTdvNGRIYkRIcDBXTjNvdmJZR0lHaUNzRkliSm9hMkROcldqSUVObzR1WHArL3NnWnc0NTdsVzFqOStDcTI5Tk91N3o5UkxvcjF4WHZWZ1UiLCJtYWMiOiI2YzZkOTFiNTM2ZDY5NDczZGRiMmVhZjM2N2Q2MzlhMWY0MzViM2I4YTNlYzA2NzYwZWE1NzliMDliZmMwMWMzIiwidGFnIjoiIn0%3D'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
