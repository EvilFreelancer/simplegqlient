# SimpleGQLient - Simple GraphQL client

The simplest GraphQL client written in PHP.
Inspired by the [Lighthouse PHP](https://lighthouse-php.com/) project,
in particular by [embedded client](https://github.com/nuwave/lighthouse/blob/master/src/Testing/MakesGraphQLRequests.php)
that can be used for testing of Laravel-based GraphQL
implementation of server.

```shell
composer require evilfreelancer/simplegqlient
```

## Small example

```php
require_once __DIR__ . '/../vendor/autoload.php';

$githubToken = 'xxx';

$client = new \SimpleGQLient\Client('https://api.github.com/graphql', [
    'Authorization' => 'Bearer ' . $githubToken,
    'Accept'        => 'application/vnd.github.hawkgirl-preview+json,',
]);

$response = $client->graphQL(/** @lang GraphQL */ '
{
  user(login: "evilfreelancer") {
    repositories(ownerAffiliations: OWNER, isFork: false, first: 100) {
      nodes {
        name
        languages(first: 10, orderBy: { field: SIZE, direction: DESC }) {
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

// \Psr\Http\Message\ResponseInterface in response
$output = $response->getBody()->getContents();
var_dump($output);
```

## Roadmap

- [x] Basic client
- [ ] Multipart support
