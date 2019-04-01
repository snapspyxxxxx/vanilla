/**
 * @author Adam Charron <adam.c@vanillaforums.com>
 * @copyright 2009-2018 Vanilla Forums Inc.
 * @license GPL-2.0-only
 */

import { getOptions } from "../getOptions";
import { KarmaRunner } from "../runners/KarmaRunner";

/**
 * Run the build. Options are passed as arguments from the command line.
 * @see https://docs.vanillaforums.com/developer/tools/building-frontend/
 */
export async function runTests() {
    const options = await getOptions();
    const runner = new KarmaRunner(options);
    await runner.run();
}
