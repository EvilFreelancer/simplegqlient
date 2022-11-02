<?php

require_once __DIR__ . '/../vendor/autoload.php';

$githubToken = 'xxx';

$client = new \SimpleGQLient\Client('https://api.github.com/graphql', [
    'Authorization' => 'Bearer ' . $githubToken,
    'Accept'        => 'application/vnd.github.hawkgirl-preview+json,',
]);

$response = $client->graphQL(
/** @lang GraphQL */ '
  {
    user(login: "evilfreelancer") {
      repositories(first: 10, orderBy: {field: NAME, direction: ASC}) {
        nodes {
          name
          dependencyGraphManifests {
            totalCount
            nodes {
              filename
            }
            edges {
              node {
                blobPath
                dependencies {
                  totalCount
                  nodes {
                    packageName
                  }
                }
              }
            }
          }
          repositoryTopics(first: 10) {
            edges {
              node {
                topic {
                  name
                }
              }
            }
          }
          languages(first: 10, orderBy: {field: SIZE, direction: DESC}) {
            edges {
              size
              node {
                color
                name
              }
            }
          }
        }
      }
    }
  }
');

$output = $response->getBody()->getContents();

dd($output);
