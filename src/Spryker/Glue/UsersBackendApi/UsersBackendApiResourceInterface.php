<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\UsersBackendApi;

use Generated\Shared\Transfer\UserCriteriaTransfer;
use Generated\Shared\Transfer\UserResourceCollectionTransfer;

interface UsersBackendApiResourceInterface
{
    /**
     * Specification:
     * - Retrieves multiple user resources by criteria.
     * - Returns the collection of user rest resources.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\UserCriteriaTransfer $userCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\UserResourceCollectionTransfer
     */
    public function getUserResourceCollection(UserCriteriaTransfer $userCriteriaTransfer): UserResourceCollectionTransfer;
}
