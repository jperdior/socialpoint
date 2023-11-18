# Test

Your task is to implement a service that maintains a "real-time" ranking of users playing a specific game.

## Requirements

* Clients submit user scores when they achieve important milestones in the game
* Clients can submit absolute scores or relative scores, for example: {"user" :123, "total": 250}, or {"user": 456, "score": "+10"}, or {"user": 789, score: "-20"}
* Any client can request the ranking at any time, using one of the following requests:
  * Absolute ranking, for example: Top100, Top200, Top500
  * Relative ranking, for instance: At100/3, meaning 3 users around position 100th of the ranking, that is positioned 97th, 98th, 99th, 100th, 101st, 102nd, 103rd
  * The response to ask for ranking should have the following format: `{"data":["01H5MSZ9M9E5Y0A26REDGNPJY7":9966, "01H5MSZ9M97H257CX7G7AGVCSJ":9758]}`

## Technical requirements

* We offer you a Scaffold of the project, with enough boilerplate to start your test, the main requirements is that the
  Behat test that we offer you must be turned into green when you finish your test.
* You can't modify the behat test in any way, you will be the responsible to adapt your code in the way that make the tests pass.
  * However, it is allowed to add additional test Features, Scenarios and Contexts, including adding new Scenarios in existing Features or new functions in existing Contexts, **so long as existing code in the provided Features and Contexts is not modified** 
* We offer you a `Kernel` like a started point, feel free to modify the `constructor` and `run` function as you need.
* The `constructor` of the `Kernel` must continue with a private scope.
* We offer you a `dataset` that you must use in your application.
* The code to run your application is in `public/index.php`
* **Do not couple yourself to a specific framework**, as the test is pretty simple we prefer to see how big your knowledge of what goes under the hood
* **Do not use any database or external storage system**, just **keep the ranking in-memory**
* The solution should be scoped as if it were a real production-grade service: It should **meet all the requirements**, but still be **clean and maintainable as a long-term enterprise service with a growing Domain**.

## Preparing the environment
Run docker containers

```sh
docker compose up -d
```

Install all dependencies

```sh
make composer-install
```

### Execute tests

```sh
make behat
```

### Access to the API

We provided the `nginx` container to access to your API in the port `8080`. Once you have your project up and running
you be able to access via `HTTP` on `http://localhost:8080` and you should see the message: `hello Socialpoint!`

## Goals to evaluate

* How you approach the project (we left some stuff  intentionally open, so you have to evaluate trade-offs and make some decisions)
* How you design and architecture the system
* How you test and ensure the overall quality of the solution
* Cohesive and fully-understood design will be valued over cutting edge approaches.
  * However, cutting edge approaches are still valid if fully understood and properly scoped.

## What to deliver
* Create a zip file containing all the source code files you needed for your implementation
* Your code must compile and run, we won’t accept a partial or a non-working solution
