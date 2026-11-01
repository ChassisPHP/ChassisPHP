#!/bin/bash
# Run the framework test suite in a podman container.
# Usage: tests/scripts/run-tests.sh [PHP_VERSION ...]   (default: 7.4)
# Set FORCE_BUILD=true to rebuild the image.

set -e

PROJECT_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/../.." && pwd)"
VERSIONS=("${@:-7.4}")

if ! command -v podman &> /dev/null; then
    echo "Podman not found. See https://podman.io/getting-started/installation"
    exit 1
fi

STATUS=0
for VERSION in "${VERSIONS[@]}"; do
    IMAGE="chassisphp:test-$VERSION"

    if [ "${FORCE_BUILD:-false}" = "true" ] || ! podman image exists "$IMAGE"; then
        echo "Building $IMAGE..."
        podman build --build-arg PHP_VERSION="$VERSION" \
            -f "$PROJECT_ROOT/tests/containers/unit.Dockerfile" -t "$IMAGE" "$PROJECT_ROOT"
    fi

    echo "Running tests on PHP $VERSION..."
    if podman run --rm -v "$PROJECT_ROOT":/src:ro,Z "$IMAGE"; then
        echo "PHP $VERSION: passed"
    else
        echo "PHP $VERSION: FAILED"
        STATUS=1
    fi
done

exit $STATUS
