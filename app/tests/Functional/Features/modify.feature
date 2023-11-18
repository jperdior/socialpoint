Feature: modify

  Scenario Outline: Receive a request to modify the ranking
    When Request with body <requestBody> for the user id <userId> is received
    Then The score for the user with id <userId> should be <score>
    Examples:
      | requestBody                                            | userId                     | score |
      | {"user_id":"01H5MSZ9MHSZ0PPM4200XF3BNN", "score":100}  | 01H5MSZ9MHSZ0PPM4200XF3BNN | 7457  |
      | {"user_id":"01H5MSZ9MPZ0K2S7KWR32JYDPM", "score":-100} | 01H5MSZ9MPZ0K2S7KWR32JYDPM | 6286  |
      | {"user_id":"01H5MSZ9MXHMYCRQ0A106KF04T", "total":7345} | 01H5MSZ9MXHMYCRQ0A106KF04T | 7345  |
