<?php

# points in universe
$points = [
    [39.93, 116.40],
    [35.40, 139.45],
    [43.8, 131.54],
    [14.40, -17.28],
    [1.14, 103.55],
    [37.47, -122.26],
    [-36.52, 174.45],
    [51.32, -0.5],
    [64.4, -21.58],
    [48.86, 2.34],
    [50.5, 14.26],
    [40.47, -73.58],
    [28.60, 77.22],
    [-22.57, -43.12],
    [19.26, -99.7],
    [-12, -77.2],
    [55.45, 37.36],
    [30.2, 31.21],
    [43.40, -79.24],
    [-12.56, -38.27],
    [10.28, -67.2],
    [9.55, -84.02],
    [-15.25, 28.16],
    [33.35, -7.39],
    [51.10, 71.30],
    [13.45, 100.30],
    [-31.57, 115.52],
    [-37.47, 144.58],
    [49.16,-123.07],
    [61.17, -150.02],
    [5.35, -0.06],
    [31.78, 35.22]
];

/* $points = [
    [0, 0],
    [1, 1],
    [9, 3.5],
    [6, 4.2],
    [2.3, 7.8],
    [8.3, 9.2],
    [3.8, 2.2],
    [4.4, 8.2],
    [7, 3],
    //[1.2, 9],
    [5, 5]
]; */

$shortestDistance = 0;
$shortestRoute    = [];

/**
 * Calculate total distance to visit all points in $route in order.
 * Will abort and return a 0 if we exceed $shortestDistance.
 */
function calculateRouteDistance($route) {

    global $shortestDistance;
    $distance = 0;

    for ($key=1; $key<count($route); $key++) { # quicker than foreach array_keys (8% speedup)

        $distance += sqrt(
            pow($route[$key][0] - $route[$key-1][0], 2) +
            pow($route[$key][1] - $route[$key-1][1], 2)
        );

        # optimization (25% speedup) - return a zero and skip calculating the
        # remainder of the route if we've exceeded $shortestDistance
        if ($shortestDistance and $distance > $shortestDistance)
            return 0;

    }

    return $distance;

}

/**
 * Generator function based on Heap's algorithm
 * https://en.wikipedia.org/wiki/Heap%27s_algorithm
 */
function newRoute($points) {
    if (count($points) <= 1) {
        yield $points;
    } else {
        foreach (newRoute(array_slice($points, 1)) as $route) {
            foreach (range(0, count($points) - 1) as $i) {
                yield array_merge(
                    array_slice($route, 0, $i),
                    [$points[0]],
                    array_slice($route, $i)
                );
            }
        }
    }
}


# should start and end at $point[0] (home), so remove and store that.
# routes are then all the possible permutations of the remaining points
# with home as the start and end point
$home       = array_shift($points);
$start_time = microtime(true);
$count      = 0;

# iterate over all possible routes
foreach (newRoute($points) as $route) {

    # add start and end point
    array_unshift($route, $home);
    $route[] = $home;

    if ($distance = calculateRouteDistance($route)) {
        # update shortest distance
        if (!$shortestDistance or $distance < $shortestDistance) {
            $shortestDistance = $distance;
            $shortestRoute    = $route;
        }
    }

    $count++;

}

printf("\nChecked %s routes in %s seconds.\n", number_format($count + 1), round(microtime(true) - $start_time, 2));
printf("Shortest route: %s\n", json_encode($shortestRoute));
printf("Distance: %s units\n\n", round($shortestDistance, 2));
