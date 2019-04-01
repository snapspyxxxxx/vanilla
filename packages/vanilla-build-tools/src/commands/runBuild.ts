/**
 * @author Adam Charron <adam.c@vanillaforums.com>
 * @copyright 2009-2018 Vanilla Forums Inc.
 * @license GPL-2.0-only
 */

import { getOptions } from "../getOptions";
import { BuildRunner } from "../runners/BuildRunner";

/**
 * Run the build. Options are passed as arguments from the command line.
 * @see https://docs.vanillaforums.com/developer/tools/building-frontend/
 */
export async function runBuild() {
    const options = await getOptions();
    const builder = new BuildRunner(options);
    await builder.build();
}
