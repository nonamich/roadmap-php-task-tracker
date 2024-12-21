# [Task Tracker](https://roadmap.sh/projects/task-tracker)

## Requirements

- PHP >= 8.2
- Composer >= 2

Or if you have docker, [see below](#docker)

## Install

```bash
git clone https://github.com/nonamich/roadmap-php-task-tracker.git
```

## Build

```bash
composer install
```

## Run

```bash
./bin/cli add "Buy groceries"

./bin/cli update 1 "Buy groceries and cook dinner"
./bin/cli delete 1

./bin/cli mark-in-progress 1
./bin/cli mark-done 1

./bin/cli list

./bin/cli list done
./bin/cli list todo
./bin/cli list in-progress
```

## Docker

```bash
docker build -t task-cli .
```

```bash
docker run --rm -i -t -it task-cli /bin/sh
```

Enter commands, [see above](#run)
