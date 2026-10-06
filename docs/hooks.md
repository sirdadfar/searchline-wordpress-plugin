# Developer hooks

Filters:
- slwc_inquiry_definitions
- slwc_before_request
- slwc_after_response
- slwc_inquiry_params
- slwc_evaluate_result
- slwc_should_run_inquiry
- slwc_checkout_fields
- slwc_field_validation

Actions:
- slwc_result_actions
- slwc_inquiry_completed
- slwc_inquiry_failed

Extensions should validate their own input and must not expose sensitive inquiry results to customers.
