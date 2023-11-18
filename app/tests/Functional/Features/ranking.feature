Feature: ranking

  Scenario Outline: A user ask for an absolute ranking
    When Ask for a "<top>" ranking
    Then The absolute "<top>" ranking is returned
    Examples:
      | top   |
      | top3   |
      | top10  |
      | top100 |

  Scenario Outline: A user ask for a relative ranking
    When Ask for a "<top>" ranking
    Then The relative "<top>" ranking is returned
    Examples:
      | top   |
      | At5/2   |
      | At10/3  |
      | At100/1 |

