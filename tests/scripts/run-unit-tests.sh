#!/bin/bash
# tests/scripts/run-unit-tests.sh
# Run framework unit tests in isolated container (Phase 1)

set -e

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PROJECT_ROOT="$(cd "$SCRIPT_DIR/../.." && pwd)"

echo "🧪 ChassisPHP Framework Unit Tests (Containerized)"
echo "================================================"

# Check if Podman is available
if ! command -v podman &> /dev/null; then
    echo "❌ Podman not found. Please install Podman first."
    echo "   Visit: https://podman.io/getting-started/installation"
    exit 1
fi

# Create test network if it doesn't exist
echo "📡 Setting up test network..."
if ! podman network exists chassisphp-test 2>/dev/null; then
    podman network create chassisphp-test
    echo "✅ Created chassisphp-test network"
else
    echo "✅ chassisphp-test network already exists"
fi

# Build unit test container if it doesn't exist or if forced
FORCE_BUILD=${FORCE_BUILD:-false}
if [ "$FORCE_BUILD" = "true" ] || ! podman image exists chassisphp:unit 2>/dev/null; then
    echo "🏗️  Building unit test container..."
    podman build -f tests/containers/unit.Dockerfile -t chassisphp:unit "$PROJECT_ROOT"
    echo "✅ Unit test container built successfully"
else
    echo "✅ Unit test container already exists (use FORCE_BUILD=true to rebuild)"
fi

# Run unit tests
echo "🚀 Running unit tests in container..."
echo "   Container: chassisphp:unit"
echo "   Bootstrap: tests/bootstrap-minimal.php"
echo "   Tests: Unit test suite only"
echo ""

# Run the container with mounted source code (read-only)
podman run --rm \
    --name chassisphp-unit-test-$$ \
    --network chassisphp-test \
    -v "$PROJECT_ROOT":/app:ro,Z \
    chassisphp:unit \
    /opt/phpunit/vendor/bin/phpunit \
        --testsuite="ChassisPHP Unit Tests"
        --bootstrap=tests/bootstrap-minimal.php \
        --colors=always \
        --verbose

RESULT=$?

if [ $RESULT -eq 0 ]; then
    echo ""
    echo "✅ Unit tests completed successfully!"
    echo "🎉 Phase 1 container testing is working!"
else
    echo ""
    echo "❌ Unit tests failed (exit code: $RESULT)"
    echo "💡 Check the output above for details"
fi

exit $RESULT