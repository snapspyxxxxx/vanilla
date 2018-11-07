<?php
/**
 * @author Todd Burry <todd@vanillaforums.com>
 * @copyright 2009-2018 Vanilla Forums Inc.
 * @license GPL-2.0-only
 */

namespace Vanilla\Web;

use Garden\Web\Exception\ForbiddenException;
use Garden\Web\Exception\ClientException;
use Vanilla\Exception\PermissionException;

/**
 * Resolve smart IDs against a user.
 *
 * User smart IDs can lookup fields in the user table, also UserAuthentication table for SSO.
 */
class UserSmartIDResolver {

    /** @var int Numeric ID of the current user. */
    private $currentUserID;

    /** @var bool Are email addresses used on the site? */
    private $emailEnabled = true;

    /** @var bool Can the current user view user email addresses? */
    private $viewEmail = false;

    /**
     * Lookup the user ID from the smart ID.
     *
     * @param SmartIDMiddleware $sender The middleware invoking the lookup.
     * @param string $pk The primary key of the lookup (UserID).
     * @param string $column The column to lookup.
     * @param string $value The value to lookup.
     * @return mixed Returns the smart using **SmartIDMiddleware::fetchValue()**.
     */
    public function __invoke(SmartIDMiddleware $sender, string $pk, string $column, string $value) {
        if ($column === 'email') {
            if (!$this->canViewEmail()) {
                throw new PermissionException('personalInfo.view');
            }
            if (!$this->isEmailEnabled()) {
                throw new ForbiddenException('Email addresses are disabled.');
            }
        }

        if (in_array($column, ['name', 'email'])) {
            // These are basic field lookups on the user table.
            return $sender->fetchValue('User', $pk, [$column => $value]);
        } elseif ($column === "me") {
            if (!$this->currentUserID || $this->currentUserID < 1) {
                throw new ClientException("User must be signed in to use the \"me\" smart ID.");
            }
            return $this->currentUserID;
        } else {
            // Try looking up a secondary user ID.
            return $sender->fetchValue('UserAuthentication', $pk, ['providerKey' => $column, 'foreignUserKey' => $value]);
        }
    }

    /**
     * Whether or not email addresses are enabled.
     *
     * @return bool Returns the emailEnabled.
     */
    public function isEmailEnabled(): bool {
        return $this->emailEnabled;
    }

    /**
     * Set the ID associated with the current user.
     *
     * @param int $userID
     */
    public function setCurrentUserID(int $userID) {
        $this->currentUserID = $userID;
    }

    /**
     * Set the whether or not email addresses are enabled.
     *
     * @param bool $emailEnabled The new value.
     * @return $this
     */
    public function setEmailEnabled(bool $emailEnabled) {
        $this->emailEnabled = $emailEnabled;
        return $this;
    }

    /**
     * Whether or not the user has permission to view emails.
     *
     * @return bool Returns the canViewEmail.
     */
    public function canViewEmail(): bool {
        return $this->viewEmail;
    }

    /**
     * Set whether or not the user has permission to view emails.
     *
     * @param bool $viewEmail The new value.
     * @return $this
     */
    public function setViewEmail(bool $viewEmail) {
        $this->viewEmail = $viewEmail;
        return $this;
    }

}
