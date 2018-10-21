<?php
function createResponse($msg){
  $json_answer = [
      "fulfillmentText" => $msg,
      "payload" => [
          "google" => [
              "expectUserResponse" => true,
              "richResponse" => [
                  "items" => [
                      [
                          "simpleResponse" => [
                              "textToSpeech" => $msg,
                          ]
                      ],
                  ]
              ]
          ]
      ]
  ];
  return $json_answer;
}
?>
