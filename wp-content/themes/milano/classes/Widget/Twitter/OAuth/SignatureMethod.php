<?php
/**
 * A class for implementing a Signature Method
 * See section 9 ("Signing Requests") in the spec
 */
abstract class Widget_Twitter_OAuth_SignatureMethod {
  /**
   * Needs to return the name of the Signature Method (ie HMAC-SHA1)
   * @return string
   */
  abstract public function get_name();

  /**
   * Build up the signature
   * NOTE: The output of this function MUST NOT be urlencoded.
   * the encoding is handled in OAuthRequest when the final
   * request is serialized
   * @param Widget_Twitter_OAuth_Request $request
   * @param Widget_Twitter_OAuth_Consumer $consumer
   * @param Widget_Twitter_OAuth_Token $token
   * @return string
   */
  abstract public function build_signature($request, $consumer, $token);

  /**
   * Verifies that a given signature is correct
   * @param Widget_Twitter_OAuth_Request $request
   * @param Widget_Twitter_OAuth_Consumer $consumer
   * @param Widget_Twitter_OAuth_Token $token
   * @param string $signature
   * @return bool
   */
  public function check_signature($request, $consumer, $token, $signature) {
    $built = $this->build_signature($request, $consumer, $token);
    return $built == $signature;
  }
}
?>
