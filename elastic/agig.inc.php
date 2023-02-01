<?php

function get_agig_query($queryString, $nr_hits, $ag=1, $ig=1){
    $t=explode(" ", microtime())[1];
    $body=<<<QRY
{
    "_source": true,
    "sort" : [
    "_score"
    ],
    "aggregations": {
        "filters": {
            "aggregations": {
                "filters": {
                    "aggregations": {
                        "branch": {
                            "aggregations": {
                                "branch": {
                                    "terms": {
                                        "field": "homeBranches",
                                        "size": 200
                                    }
                                }
                            },
                            "filter": {
                                "bool": {
                                    "minimum_should_match": "1",
                                    "must": [
                                        {
                                            "exists": {
                                                "field": "homeBranches"
                                            }
                                        },
                                        {
                                            "term": {
                                                "deleted": false
                                            }
                                        }
                                    ],
                                    "should": [
                                        {
                                            "multi_match": {
                                                "fields": [
                                                    "mainTitle^2",                      
                                                    "untranscribedTitle^1.3",
                                                    "work.mainEntry^1.3",
                                                    "fullTitle^1.2",
                                                    "allAgents^1.1",
                                                    "series^1.1",
                                                    "various^0.3",
                                                    "titleAll^0.5",
                                                    "hiddenSearchables^0.5",
                                                    "ids^0.5",
                                                    "mediaType^0.5",
                                                    "formats^0.5",
                                                    "work.instruments^0.5",
                                                    "publishedBy^0.5",
                                                    "work.compositionTypes^0.5",
                                                    "work.genres^0.5",
                                                    "work.subjects^0.5",
                                                    "parts^0.5",
                                                    "work.deweyNumbers^0.5"
                                                ],
                                                "operator": "AND",
                                                "query": "$queryString",
                                                "type": "cross_fields"
                                            }
                                        },
                                        {
                                            "multi_match": {
                                                "fields": [
                                                    "mainTitle^2",
                                                    "untranscribedTitle^1.3",
                                                    "work.mainEntry^1.3",
                                                    "fullTitle^1.2",
                                                    "allAgents^1.1",
                                                    "series^1.1",
                                                    "various^0.3",
                                                    "titleAll^0.5",
                                                    "hiddenSearchables^0.5",
                                                    "ids^0.5",
                                                    "mediaType^0.5",
                                                    "formats^0.5",
                                                    "work.instruments^0.5",
                                                    "publishedBy^0.5",
                                                    "work.compositionTypes^0.5",
                                                    "work.genres^0.5",
                                                    "work.subjects^0.5",
                                                    "parts^0.5",
                                                    "work.deweyNumbers^0.5"
                                                ],
                                                "query": "$queryString",
                                                "slop": 3,
                                                "type": "phrase_prefix"
                                            }
                                        }
                                    ]
                                }
                            }
                        },
                        "formats": {
                            "aggregations": {
                                "formats": {
                                    "terms": {
                                        "field": "formats.raw",
                                        "size": 200
                                    }
                                }
                            },
                            "filter": {
                                "bool": {
                                    "minimum_should_match": "1",
                                    "must": [
                                        {
                                            "exists": {
                                                "field": "homeBranches"
                                            }
                                        },
                                        {
                                            "term": {
                                                "deleted": false
                                            }
                                        }
                                    ],
                                    "should": [
                                        {
                                            "multi_match": {
                                                "fields": [
                                                    "mainTitle^2",
                                                    "untranscribedTitle^1.3",
                                                    "work.mainEntry^1.3",
                                                    "fullTitle^1.2",
                                                    "allAgents^1.1",
                                                    "series^1.1",
                                                    "various^0.3",
                                                    "titleAll^0.5",
                                                    "hiddenSearchables^0.5",
                                                    "ids^0.5",
                                                    "mediaType^0.5",
                                                    "formats^0.5",
                                                    "work.instruments^0.5",
                                                    "publishedBy^0.5",
                                                    "work.compositionTypes^0.5",
                                                    "work.genres^0.5",
                                                    "work.subjects^0.5",
                                                    "parts^0.5",
                                                    "work.deweyNumbers^0.5"
                                                ],
                                                "operator": "AND",
                                                "query": "$queryString",
                                                "type": "cross_fields"
                                            }
                                        },
                                        {
                                            "multi_match": {
                                                "fields": [
                                                    "mainTitle^2",
                                                    "untranscribedTitle^1.3",
                                                    "work.mainEntry^1.3",
                                                    "fullTitle^1.2",
                                                    "allAgents^1.1",
                                                    "series^1.1",
                                                    "various^0.3",
                                                    "titleAll^0.5",
                                                    "hiddenSearchables^0.5",
                                                    "ids^0.5",
                                                    "mediaType^0.5",
                                                    "formats^0.5",
                                                    "work.instruments^0.5",
                                                    "publishedBy^0.5",
                                                    "work.compositionTypes^0.5",
                                                    "work.genres^0.5",
                                                    "work.subjects^0.5",
                                                    "parts^0.5",
                                                    "work.deweyNumbers^0.5"
                                                ],
                                                "query": "$queryString",
                                                "slop": 3,
                                                "type": "phrase_prefix"
                                            }
                                        }
                                    ]
                                }
                            }
                        },
                        "languages": {
                            "aggregations": {
                                "languages": {
                                    "terms": {
                                        "field": "languages",
                                        "size": 200
                                    }
                                }
                            },
                            "filter": {
                                "bool": {
                                    "minimum_should_match": "1",
                                    "must": [
                                        {
                                            "exists": {
                                                "field": "homeBranches"
                                            }
                                        },
                                        {
                                            "term": {
                                                "deleted": false
                                            }
                                        }
                                    ],
                                    "should": [
                                        {
                                            "multi_match": {
                                                "fields": [
                                                    "mainTitle^2",
                                                    "untranscribedTitle^1.3",
                                                    "work.mainEntry^1.3",
                                                    "fullTitle^1.2",
                                                    "allAgents^1.1",
                                                    "series^1.1",
                                                    "various^0.3",
                                                    "titleAll^0.5",
                                                    "hiddenSearchables^0.5",
                                                    "ids^0.5",
                                                    "mediaType^0.5",
                                                    "formats^0.5",
                                                    "work.instruments^0.5",
                                                    "publishedBy^0.5",
                                                    "work.compositionTypes^0.5",
                                                    "work.genres^0.5",
                                                    "work.subjects^0.5",
                                                    "parts^0.5",
                                                    "work.deweyNumbers^0.5"
                                                ],
                                                "operator": "AND",
                                                "query": "$queryString",
                                                "type": "cross_fields"
                                            }
                                        },
                                        {
                                            "multi_match": {
                                                "fields": [
                                                    "mainTitle^2",
                                                    "untranscribedTitle^1.3",
                                                    "work.mainEntry^1.3",
                                                    "fullTitle^1.2",
                                                    "allAgents^1.1",
                                                    "series^1.1",
                                                    "various^0.3",
                                                    "titleAll^0.5",
                                                    "hiddenSearchables^0.5",
                                                    "ids^0.5",
                                                    "mediaType^0.5",
                                                    "formats^0.5",
                                                    "work.instruments^0.5",
                                                    "publishedBy^0.5",
                                                    "work.compositionTypes^0.5",
                                                    "work.genres^0.5",
                                                    "work.subjects^0.5",
                                                    "parts^0.5",
                                                    "work.deweyNumbers^0.5"
                                                ],
                                                "query": "$queryString",
                                                "slop": 3,
                                                "type": "phrase_prefix"
                                            }
                                        }
                                    ]
                                }
                            }
                        },
                        "mediaType": {
                            "aggregations": {
                                "mediaType": {
                                    "terms": {
                                        "field": "mediaType.raw",
                                        "size": 200
                                    }
                                }
                            },
                            "filter": {
                                "bool": {
                                    "minimum_should_match": "1",
                                    "must": [
                                        {
                                            "exists": {
                                                "field": "homeBranches"
                                            }
                                        },
                                        {
                                            "term": {
                                                "deleted": false
                                            }
                                        }
                                    ],
                                    "should": [
                                        {
                                            "multi_match": {
                                                "fields": [
                                                    "mainTitle^2",
                                                    "untranscribedTitle^1.3",
                                                    "work.mainEntry^1.3",
                                                    "fullTitle^1.2",
                                                    "allAgents^1.1",
                                                    "series^1.1",
                                                    "various^0.3",
                                                    "titleAll^0.5",
                                                    "hiddenSearchables^0.5",
                                                    "ids^0.5",
                                                    "mediaType^0.5",
                                                    "formats^0.5",
                                                    "work.instruments^0.5",
                                                    "publishedBy^0.5",
                                                    "work.compositionTypes^0.5",
                                                    "work.genres^0.5",
                                                    "work.subjects^0.5",
                                                    "parts^0.5",
                                                    "work.deweyNumbers^0.5"
                                                ],
                                                "operator": "AND",
                                                "query":"$queryString",
                                                "type": "cross_fields"
                                            }
                                        },
                                        {
                                            "multi_match": {
                                                "fields": [
                                                    "mainTitle^2",
                                                    "untranscribedTitle^1.3",
                                                    "work.mainEntry^1.3",
                                                    "fullTitle^1.2",
                                                    "allAgents^1.1",
                                                    "series^1.1",
                                                    "various^0.3",
                                                    "titleAll^0.5",
                                                    "hiddenSearchables^0.5",
                                                    "ids^0.5",
                                                    "mediaType^0.5",
                                                    "formats^0.5",
                                                    "work.instruments^0.5",
                                                    "publishedBy^0.5",
                                                    "work.compositionTypes^0.5",
                                                    "work.genres^0.5",
                                                    "work.subjects^0.5",
                                                    "parts^0.5",
                                                    "work.deweyNumbers^0.5"
                                                ],
                                                "query": "$queryString",
                                                "slop": 3,
                                                "type": "phrase_prefix"
                                            }
                                        }
                                    ]
                                }
                            }
                        },
                        "work.audiences": {
                            "aggregations": {
                                "work.audiences": {
                                    "terms": {
                                        "field": "work.audiences",
                                        "size": 200
                                    }
                                }
                            },
                            "filter": {
                                "bool": {
                                    "minimum_should_match": "1",
                                    "must": [
                                        {
                                            "exists": {
                                                "field": "homeBranches"
                                            }
                                        },
                                        {
                                            "term": {
                                                "deleted": false
                                            }
                                        }
                                    ],
                                    "should": [
                                        {
                                            "multi_match": {
                                                "fields": [
                                                    "mainTitle^2",
                                                    "untranscribedTitle^1.3",
                                                    "work.mainEntry^1.3",
                                                    "fullTitle^1.2",
                                                    "allAgents^1.1",
                                                    "series^1.1",
                                                    "various^0.3",
                                                    "titleAll^0.5",
                                                    "hiddenSearchables^0.5",
                                                    "ids^0.5",
                                                    "mediaType^0.5",
                                                    "formats^0.5",
                                                    "work.instruments^0.5",
                                                    "publishedBy^0.5",
                                                    "work.compositionTypes^0.5",
                                                    "work.genres^0.5",
                                                    "work.subjects^0.5",
                                                    "parts^0.5",
                                                    "work.deweyNumbers^0.5"
                                                ],
                                                "operator": "AND",
                                                "query": "$queryString",
                                                "type": "cross_fields"
                                            }
                                        },
                                        {
                                            "multi_match": {
                                                "fields": [
                                                    "mainTitle^2",
                                                    "untranscribedTitle^1.3",
                                                    "work.mainEntry^1.3",
                                                    "fullTitle^1.2",
                                                    "allAgents^1.1",
                                                    "series^1.1",
                                                    "various^0.3",
                                                    "titleAll^0.5",
                                                    "hiddenSearchables^0.5",
                                                    "ids^0.5",
                                                    "mediaType^0.5",
                                                    "formats^0.5",
                                                    "work.instruments^0.5",
                                                    "publishedBy^0.5",
                                                    "work.compositionTypes^0.5",
                                                    "work.genres^0.5",
                                                    "work.subjects^0.5",
                                                    "parts^0.5",
                                                    "work.deweyNumbers^0.5"
                                                ],
                                                "query": "$queryString",
                                                "slop": 3,
                                                "type": "phrase_prefix"
                                            }
                                        }
                                    ]
                                }
                            }
                        }
                    },
                    "filter": {
                        "bool": {
                            "minimum_should_match": "1",
                            "should": [
                                {
                                    "multi_match": {
                                        "fields": [
                                            "mainTitle^2",
                                            "untranscribedTitle^1.3",
                                            "work.mainEntry^1.3",
                                            "fullTitle^1.2",
                                            "allAgents^1.1",
                                            "series^1.1",
                                            "various^0.3",
                                            "titleAll^0.5",
                                            "hiddenSearchables^0.5",
                                            "ids^0.5",
                                            "mediaType^0.5",
                                            "formats^0.5",
                                            "work.instruments^0.5",
                                            "publishedBy^0.5",
                                            "work.compositionTypes^0.5",
                                            "work.genres^0.5",
                                            "work.subjects^0.5",
                                            "parts^0.5",
                                            "work.deweyNumbers^0.5"
                                        ],
                                        "operator": "AND",
                                        "query": "$queryString",
                                        "type": "cross_fields"
                                    }
                                },
                                {
                                    "multi_match": {
                                        "fields": [
                                            "mainTitle^2",
                                            "untranscribedTitle^1.3",
                                            "work.mainEntry^1.3",
                                            "fullTitle^1.2",
                                            "allAgents^1.1",
                                            "series^1.1",
                                            "various^0.3",
                                            "titleAll^0.5",
                                            "hiddenSearchables^0.5",
                                            "ids^0.5",
                                            "mediaType^0.5",
                                            "formats^0.5",
                                            "work.instruments^0.5",
                                            "publishedBy^0.5",
                                            "work.compositionTypes^0.5",
                                            "work.genres^0.5",
                                            "work.subjects^0.5",
                                            "parts^0.5",
                                            "work.deweyNumbers^0.5"
                                        ],
                                        "query": "$queryString",
                                        "slop": 3,
                                        "type": "phrase_prefix"
                                    }
                                }
                            ]
                        }
                    }
                }
            },
            "global": {}
        }
    },
    "from": 0,
    "query": {
        "function_score": {
            "functions": [
                {
                    "script_score": {
                        "script": {
                            "lang": "painless",
                            "params": {
                                "ageGain": $ag,
                                "ageScale": 30000,
                                "itemsGain": $ig,
                                "now": $t
                            },
                            "source": "def score_multiplier = 1.0;\\n    def age_gain = params.ageGain;\\n    def age_scale = params.ageScale;\\n    def items_gain = params.itemsGain;\\n\\tdef lang_multipliers = [\"Svensk\": 1.3,\"Nordsamisk\": 1.2,\"Sørsamisk\": 1.1,\"Spansk\": 1.1,\"Norsk (bokmål)\": 1.5,\"Norsk (nynorsk)\": 1.5,\"Dansk\": 1.3,\"Tysk\": 1.2,\"Fransk\": 1.2,\"Lulesamisk\": 1.1,\"Italiensk\": 1.1,\"Norsk\": 1.5,\"Engelsk\": 1.4];\\n\\n    score_multiplier *= (1.0 + age_gain * (1.0 - Math.min((params.now - (doc['created'].value.toInstant().toEpochMilli()) * 1)/86400000, age_scale)/age_scale));\\n    if (doc['mediaType.raw'].value == 'Bok' && doc['languages'].length >= 1) {\\n        def lang_multiplier = lang_multipliers.get(doc['languages'][0]);\\n        if (lang_multiplier != null) {\\n            score_multiplier *= lang_multiplier;\\n        }\\n    }\\n    score_multiplier *= 1.0 + items_gain * saturation(doc['numItems'].value, 500);\\n    return score_multiplier;"
                        }
                    }
                }
            ],
            "query": {
                "bool": {
                    "minimum_should_match": "1",
                    "must": [
                        {
                            "exists": {
                                "field": "homeBranches"
                            }
                        },
                        {
                            "term": {
                                "deleted": false
                            }
                        }
                    ],
                    "should": [
                        {
                            "multi_match": {
                                "fields": [
                                    "mainTitle^2",
                                    "untranscribedTitle^1.3",
                                    "work.mainEntry^1.3",
                                    "fullTitle^1.2",
                                    "allAgents^1.1",
                                    "series^1.1",
                                    "various^0.3",
                                    "titleAll^0.5",
                                    "hiddenSearchables^0.5",
                                    "ids^0.5",
                                    "mediaType^0.5",
                                    "formats^0.5",
                                    "work.instruments^0.5",
                                    "publishedBy^0.5",
                                    "work.compositionTypes^0.5",
                                    "work.genres^0.5",
                                    "work.subjects^0.5",
                                    "parts^0.5",
                                    "work.deweyNumbers^0.5"
                                ],
                                "operator": "AND",
                                "query": "$queryString",
                                "type": "cross_fields"
                            }
                        },
                        {
                            "multi_match": {
                                "fields": [
                                    "mainTitle^2",
                                    "untranscribedTitle^1.3",
                                    "work.mainEntry^1.3",
                                    "fullTitle^1.2",
                                    "allAgents^1.1",
                                    "series^1.1",
                                    "various^0.3",
                                    "titleAll^0.5",
                                    "hiddenSearchables^0.5",
                                    "ids^0.5",
                                    "mediaType^0.5",
                                    "formats^0.5",
                                    "work.instruments^0.5",
                                    "publishedBy^0.5",
                                    "work.compositionTypes^0.5",
                                    "work.genres^0.5",
                                    "work.subjects^0.5",
                                    "parts^0.5",
                                    "work.deweyNumbers^0.5"
                                ],
                                "query": "$queryString",
                                "slop": 3,
                                "type": "phrase_prefix"
                            }
                        }
                    ]
                }
            }
        }
    },
    "size": $nr_hits,
    "stored_fields": [
        "work.id",
        "mediaType",
        "sellingPoint"
    ]
}

QRY;
    return $body;
}



?>