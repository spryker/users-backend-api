<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Glue\UsersBackendApi\Plugin\GlueBackendApiApplicationGlueJsonApiConventionConnector;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\GlueRequestTransfer;
use Generated\Shared\Transfer\GlueResourceTransfer;
use Generated\Shared\Transfer\WarehouseUserAssignmentsBackendApiAttributesTransfer;
use Spryker\Glue\UsersBackendApi\Plugin\GlueBackendApiApplicationGlueJsonApiConventionConnector\UserByWarehouseUserAssignmentBackendResourceRelationshipPlugin;
use SprykerTest\Glue\UsersBackendApi\UsersBackendApiPluginTester;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Glue
 * @group UsersBackendApi
 * @group Plugin
 * @group GlueBackendApiApplicationGlueJsonApiConventionConnector
 * @group UserByWarehouseUserAssignmentBackendResourceRelationshipPluginTest
 * Add your own group annotations below this line
 */
class UserByWarehouseUserAssignmentBackendResourceRelationshipPluginTest extends Unit
{
    /**
     * @uses \Spryker\Glue\UsersBackendApi\UsersBackendApiConfig::RESOURCE_TYPE_USERS
     *
     * @var string
     */
    protected const RESOURCE_TYPE_USERS = 'users';

    /**
     * @uses \Spryker\Glue\WarehouseUsersBackendApi\WarehouseUsersBackendApiConfig::RESOURCE_TYPE_WAREHOUSE_USER_ASSIGNMENTS
     *
     * @var string
     */
    protected const RESOURCE_TYPE_WAREHOUSE_USER_ASSIGNMENTS = 'warehouse-user-assignments';

    /**
     * @var string
     */
    protected const FAKE_USER_UUID = 'fake-uuid';

    /**
     * @var \SprykerTest\Glue\UsersBackendApi\UsersBackendApiPluginTester
     */
    protected UsersBackendApiPluginTester $tester;

    /**
     * @return void
     */
    public function testAddRelationshipsWillAddUsersResourceToWarehouseUserAssignmentsResource(): void
    {
        // Arrange
        $userTransfer = $this->tester->haveUser();
        $warehouseUserAssignmentsBackendApiAttributesTransfer = (new WarehouseUserAssignmentsBackendApiAttributesTransfer())
            ->setUserUuid($userTransfer->getUuid());

        $glueResourceTransfers = [
            (new GlueResourceTransfer())
                ->setType(static::RESOURCE_TYPE_WAREHOUSE_USER_ASSIGNMENTS)
                ->setAttributes($warehouseUserAssignmentsBackendApiAttributesTransfer),
        ];

        // Act
        (new UserByWarehouseUserAssignmentBackendResourceRelationshipPlugin())->addRelationships($glueResourceTransfers, new GlueRequestTransfer());

        // Assert
        $this->assertCount(1, $glueResourceTransfers);

        $glueResourceTransfer = reset($glueResourceTransfers);
        $this->assertCount(1, $glueResourceTransfer->getRelationships());

        $glueRelationshipTransfer = $glueResourceTransfer->getRelationships()->getIterator()->current();
        $this->assertCount(1, $glueRelationshipTransfer->getResources());

        $usersGlueResourceTransfer = $glueRelationshipTransfer->getResources()->getIterator()->current();
        $this->assertSame($userTransfer->getUuidOrFail(), $usersGlueResourceTransfer->getId());
        $this->assertSame(static::RESOURCE_TYPE_USERS, $usersGlueResourceTransfer->getType());

        $usersBackendApiAttributesTransfer = $usersGlueResourceTransfer->getAttributes();
        $this->assertSame($userTransfer->getUsernameOrFail(), $usersBackendApiAttributesTransfer->getUsername());
        $this->assertSame($userTransfer->getFirstNameOrFail(), $usersBackendApiAttributesTransfer->getFirstName());
        $this->assertSame($userTransfer->getLastNameOrFail(), $usersBackendApiAttributesTransfer->getLastName());
    }

    /**
     * @return void
     */
    public function testAddRelationshipsWillNotAddUsersResourceToWarehouseUserAssignmentsResourceWithWrongType(): void
    {
        // Arrange
        $userTransfer = $this->tester->haveUser();
        $warehouseUserAssignmentsBackendApiAttributesTransfer = (new WarehouseUserAssignmentsBackendApiAttributesTransfer())
            ->setUserUuid($userTransfer->getUuid());

        $glueResourceTransfers = [
            (new GlueResourceTransfer())
                ->setType('fake-type')
                ->setAttributes($warehouseUserAssignmentsBackendApiAttributesTransfer),
        ];

        // Act
        (new UserByWarehouseUserAssignmentBackendResourceRelationshipPlugin())->addRelationships($glueResourceTransfers, new GlueRequestTransfer());

        // Assert
        $this->assertCount(1, $glueResourceTransfers);
        $this->assertCount(0, $glueResourceTransfers[0]->getRelationships());
    }

    /**
     * @return void
     */
    public function testAddRelationshipsWillNotAddUsersResourceIfUserIsNotFoundByUuid(): void
    {
        // Arrange
        $warehouseUserAssignmentsBackendApiAttributesTransfer = (new WarehouseUserAssignmentsBackendApiAttributesTransfer())
            ->setUserUuid(static::FAKE_USER_UUID);
        $glueResourceTransfers = [
            (new GlueResourceTransfer())->setAttributes($warehouseUserAssignmentsBackendApiAttributesTransfer),
        ];

        // Act
        (new UserByWarehouseUserAssignmentBackendResourceRelationshipPlugin())->addRelationships(
            $glueResourceTransfers,
            new GlueRequestTransfer(),
        );

        // Assert
        $this->assertCount(1, $glueResourceTransfers);

        $glueResourceTransfer = reset($glueResourceTransfers);
        $this->assertCount(0, $glueResourceTransfer->getRelationships());
    }
}
